@echo off
cls

set AHEADER=-H "Accept: application/json"
set CHEADER=-H "Content-Type: application/json"
set BASE_URL=http://localhost:8000
set JSON_DATA=--data {\"email\":\"admin@localhost.loc\",\"password\":\"p@55w0rd/*\"}

curl -s -k -X POST %AHEADER% %CHEADER% %BASE_URL%/api/login %JSON_DATA% | jq -r ".payload.token" > tmpFile
set /p TOKEN= < tmpFile 
set AUTH_HEADER=-H "Authorization: Bearer %TOKEN%"
::del tmpFile  

set JSON_DATA=--data {\"email\":\"rnapoles@localhost.loc\",\"password\":\"p@55w0rd/*\"}
::curl -v -k -X POST %AHEADER% %CHEADER% %BASE_URL%/api/register %JSON_DATA%

set JSON_DATA=--data {\"name\":\"Big Hook\",\"purchase_price\":\"10\",\"sale_price\":\"20\",\"units_in_stock\":\"6\",\"category_id\":\"1\"}
curl -s -k -X POST %AHEADER% %CHEADER% %BASE_URL%/api/product/create %JSON_DATA%