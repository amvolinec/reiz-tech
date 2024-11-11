<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobData;

    public function __construct($jobData)
    {
        $this->jobData = $jobData;
    }

    /**
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $results = [];

        foreach ($this->jobData['urls'] as $url) {
            $client = new Client;
            $response = $client->request('GET', $url);
            $content = $response->getBody()->getContents();

            $crawler = new Crawler($content);
            $data = [];

            foreach ($this->jobData['selectors'] as $selector) {
                $data[$selector] = $crawler->filter($selector)->each(function (Crawler $node) {
                    return $node->text();
                });
            }

            $results[$url] = $data;
        }

        $this->jobData['status'] = 'completed';
        $this->jobData['result'] = $results;

        Redis::set("job:{$this->jobData['id']}", json_encode($this->jobData));
    }
}
