#!/bin/sh

#
# This file is a hack to suppress warnings from Roave BC check
#

echo "Running..."

# Capture output to variable
OUTPUT=$(./vendor/bin/roave-backward-compatibility-check 2>&1)
echo "$OUTPUT"

# Remove rows we want to suppress
OUTPUT=`echo "$OUTPUT" | sed '/The return type of Github\\\HttpClient\\\Plugin\\\Authentication#handleRequest() changed from no type to Http\\\Promise\\\Promise/'d`
OUTPUT=`echo "$OUTPUT" | sed '/The return type of Github\\\HttpClient\\\Plugin\\\Authentication#handleRequest() changed from no type to Http\\\Promise\\\Promise/'d`
OUTPUT=`echo "$OUTPUT" | sed '/The parameter $exception of Github\\\HttpClient\\\Plugin\\\History#addFailure() changed from Http\\\Client\\\Exception to a non-contravariant Psr\\\Http\\\Client\\\ClientExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/The parameter $exception of Github\\\HttpClient\\\Plugin\\\History#addFailure() changed from Http\\\Client\\\Exception to Psr\\\Http\\\Client\\\ClientExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/The return type of Github\\\HttpClient\\\Plugin\\\PathPrepend#handleRequest() changed from no type to Http\\\Promise\\\Promise/'d`
OUTPUT=`echo "$OUTPUT" | sed '/The return type of Github\\\HttpClient\\\Plugin\\\GithubExceptionThrower#handleRequest() changed from no type to Http\\\Promise\\\Promise/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method getMessage() was added to interface Github\\\Exception\\\ExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method getCode() was added to interface Github\\\Exception\\\ExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method getFile() was added to interface Github\\\Exception\\\ExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method getLine() was added to interface Github\\\Exception\\\ExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method getTrace() was added to interface Github\\\Exception\\\ExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method getPrevious() was added to interface Github\\\Exception\\\ExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method getTraceAsString() was added to interface Github\\\Exception\\\ExceptionInterface/'d`
OUTPUT=`echo "$OUTPUT" | sed '/Method __toString() was added to interface Github\\\Exception\\\ExceptionInterface/'d`

# Number of rows we found with "[BC]" in them
BC_BREAKS=`echo "$OUTPUT" | grep -o '\[BC\]' | wc -l | awk '{ print $1 }'`

# The last row of the output is "X backwards-incompatible changes detected". Find X.
STATED_BREAKS=`echo "$OUTPUT" | tail -n 1 | awk -F' ' '{ print $1 }'`

# If
#   We found "[BC]" in the command output after we removed suppressed lines
# OR
#   We have suppressed X number of BC breaks. If $STATED_BREAKS is larger than X
# THEN
#   exit 1

if [ $BC_BREAKS -gt 0 ] || [ $STATED_BREAKS -gt 13 ]; then
    echo "EXIT 1"
    exit 1
fi

# No BC breaks found
echo "EXIT 0"
exit 0
