const mix = require("laravel-mix");
const fs = require("fs");
const path = require("path");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.sourceMaps(true, 'source-map');

function findFiles(dir) {
  return fs.readdirSync(dir).filter((file) => {
    return fs.statSync(`${dir}/${file}`).isFile();
  });
}

function buildSass(dir, dest) {
  findFiles(dir).forEach(function (file) {
    if (!file.startsWith("_")) {
      mix.sass(dir + "/" + file, dest);
    }
  });
}

buildSass("resources/scss", "public/css");

function scanDir(dir, baseDir = "") {
  let entries = {};
  fs.readdirSync(dir).forEach((file) => {
    const fullPath = path.join(dir, file);
    const relativePath = path.join(baseDir, file);
    if (fs.lstatSync(fullPath).isDirectory()) {
      Object.assign(entries, scanDir(fullPath, relativePath));
    } else if (fullPath.endsWith(".ts") && !fullPath.endsWith(".d.ts")) {
      const entryName = path.join("public/js", baseDir).replace(/\.ts$/, "");
      if (entries[entryName]) {
        entries[entryName].push(fullPath);
      } else {
        entries[entryName] = [fullPath];
      }
    }
  });
  return entries;
}

const entries = scanDir("resources/ts");

Object.keys(entries).forEach((outputPath) => {
  entries[outputPath].forEach((entry) => {
    mix.ts(entry, outputPath);
  });
});

mix.webpackConfig({
  resolve: {
    extensions: [".js", ".jsx", ".ts", ".tsx"],
  },
  module: {
    rules: [
      {
        test: /\.tsx?$/,
        loader: "ts-loader",
        exclude: /node_modules/,
      },
    ],
  },
});

mix.version();

mix.disableNotifications();

const port = process.env.PORT || 8000;
mix.browserSync("http://localhost:" + port);
