rm -r ./_release/tmp
rm -r ./_release/tmp/
rm ./_release/tmp/protected/.env

# git submodule update --init --recursive --force
mkdir ./_release/ && mkdir ./_release/tmp/
mkdir -p ./_release/tmp/public_html/ && cp -r ./public_html ./_release/tmp/ &&
mkdir -p ./_release/tmp/protected/ && cp -r ./protected ./_release/tmp/ &&
mkdir -p ./_release/tmp/framework/ && cp -r ./framework ./_release/tmp/ &&
cp LICENSE ./_release/tmp/LICENSE && 
mkdir -m 777 ./_release/tmp/protected/overrides/ && 
mkdir -m 777 ./_release/tmp/protected/runtime/ && 
mkdir -m 777 ./_release/tmp/protected/messages/ && 
mkdir -m 777 ./_release/tmp/public_html/assets/ && 
mkdir -m 777 ./_release/tmp/public_html/uploads/ && 
rm -rf ./_release/tmp/.git* &&
chmod -R 777 ./_release/tmp/protected/data/ &&
chmod -R 777 ./_release/tmp/protected/modules/ && 
chmod -R 777 ./_release/tmp/protected/vendor/ 

cd ./_release/tmp/ && zip ../openhub.zip -r -m .
cd ../..
rm -r ./_release/tmp