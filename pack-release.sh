rm -r ./_release/tmp
rm -r ./_release/tmp/

mkdir ./_release/
mkdir ./_release/tmp/

# git submodule update --init --recursive --force

mkdir -p ./_release/tmp/public_html/ && cp -r ./public_html/ ./_release/tmp/public_html/
mkdir -p ./_release/tmp/protected/ && cp -r ./protected/ ./_release/tmp/protected/
mkdir -p ./_release/tmp/framework/ && cp -r ./framework/ ./_release/tmp/framework/
cp LICENSE ./_release/tmp/LICENSE

rm ./_release/tmp/protected/.env
rm -r ./_release/tmp/protected/runtime
rm -r ./_release/tmp/protected/overrides
rm -r ./_release/tmp/public_html/assets
rm -rf ./_release/tmp/.git*

mkdir ./_release/tmp/protected/runtime/
mkdir ./_release/tmp/protected/overrides/
#mkdir ./_release/tmp/public_html/assets/

chmod -R 777 ./_release/tmp/protected/vendor
chmod -R 777 ./_release/tmp/protected/messages
chmod -R 777 ./_release/tmp/public_html/uploads
chmod -R 777 ./_release/tmp/protected/runtime
#chmod -R 777 ./_release/tmp/public_html/assets
chmod -R 777 ./_release/tmp/protected/data
chmod -R 777 ./_release/tmp/protected/modules

cd ./_release/tmp/ && zip ../openhub.zip -r -m .
cd ../..
rm -r ./_release/tmp