const Crawler = require("simplecrawler");
const cheerio = require("cheerio");
const fs = require("fs");

const crawler = new Crawler("https://sf-cliniken.fi/");

const outputFile = "output.csv";
fs.writeFileSync(outputFile, "URL,Title,Description\n");

crawler.downloadUnsupported = false;
crawler.respectRobotsTxt = true;

crawler.discoverResources = function (buffer, queueItem) {
    const $ = cheerio.load(buffer.toString("utf8"));
    return $("a[href]").map(function () {
        return $(this).attr("href");
    }).get();
};

crawler.on("fetchcomplete", function (queueItem, responseBuffer) {
    const html = responseBuffer.toString("utf8");
    const $ = cheerio.load(html);

    const title = $("title").text().trim().replace(/,/g, ""); 
    const description = ($('meta[name="description"]').attr("content") || "No description available").replace(/,/g, "");

    console.log(`Scraped: ${queueItem.url}`);

    fs.appendFileSync(outputFile, `"${queueItem.url}","${title}","${description}"\n`);
});

crawler.start();
