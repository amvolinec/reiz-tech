#!/bin/bash

EXIT_CODE=0

./vendor/bin/pint -v --test || EXIT_CODE=$?

./vendor/bin/phpstan --no-ansi --memory-limit=2408M  analyse app || EXIT_CODE=$?

exit $EXIT_CODE
