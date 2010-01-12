echo " ";
echo "1. Switching to JavaScript directory...";
cd ./scripts/;

echo "2. Concatenating and compressing JavaScript files...";
rm newsblocks.js;
cat *.js > __temp.js;
java -jar /yuicompressor-2.3.5/build/yuicompressor-2.3.5.jar --type js -o newsblocks.js __temp.js;
rm __temp.js;

cd ../

echo "3. Switching to CSS directory...";
cd ./css/;

echo "4. Compressing CSS files...";
rm newsblocks.css;
cat *.css > __temp.css;
java -jar /yuicompressor-2.3.5/build/yuicompressor-2.3.5.jar --type css -o newsblocks.css __temp.css;
rm __temp.css

cd ../
echo "5. Done.";
echo " ";
