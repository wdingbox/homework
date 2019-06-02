#!/bin/sh

find . -type f \( -name *.php -or -name *.html \)

echo "-------------" 

find . -type f \( -name *.php -or -name *.html \) -exec sed   -n '/echo/ p' {} + 

echo "===grep==="
grep -r "echo" . | egrep ".php|.html"





#find . -type f -name *.php -exec sed -n '' 's/echo/print/g' {} + 


