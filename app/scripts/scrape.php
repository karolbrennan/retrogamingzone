<?php
/**
 * Should handle scraping the data from the various platforms
 */

/**
 * Class Scraper will be the main work horse - and launch the scrapes
 */
class Scraper
{
    /**
     * @const integer key to not put new line
     */
    const OUTPUT_BEGIN = 1;

    /**
     * @const integer key to say ok go with new line or whatnot
     */
    const OUTPUT_FINISH = 2;

    /**
     * @const string the file in the local directory to write this to
     */
//    const OUTPUT_FILE = 'atari2600-new2.csv';
//    const OUTPUT_FILE = 'atari5200.csv';
//    const OUTPUT_FILE = 'atari7800.csv';
//    const OUTPUT_FILE = 'jaguar.csv';
//    const OUTPUT_FILE = 'intellivision.csv';
//    const OUTPUT_FILE = 'colecovision.csv';
//    const OUTPUT_FILE = 'commodore64na.csv';
//    const OUTPUT_FILE = 'segamastersystem.csv';
//    const OUTPUT_FILE = 'segacdna.csv';
//    const OUTPUT_FILE = 'sega32x.csv';
//    const OUTPUT_FILE = 'gen.csv';
//    const OUTPUT_FILE = 'segasaturn.csv';
//    const OUTPUT_FILE = 'nes.csv';
//    const OUTPUT_FILE = 'snes.csv';
//    const OUTPUT_FILE = 'n64.csv';
    const OUTPUT_FILE = 'ps1.csv';

    /**
     * @const the platform string for atari 2600
     */
//    const PLATFORM_ATARI_2600 = 'atari2600';
//    const PLATFORM_ATARI_5200 = 'atari5200';
//    const PLATFORM_ATARI_7800 = 'atari7800';
//    const PLATFORM_ATARI_JAGUAR = 'jaguar';
//    const PLATFORM_INTELLIVISION = 'intellivision';
//    const PLATFORM_COLECOVISION = 'colecovision';
//    const PLATFORM_COMMODORE_64 = 'commodore64na';
//    const PLATFORM_SEGA_MASTER_SYSTEM = 'segamastersystem';
//    const PLATFORM_SEGA_CD = 'segacdna';
//    const PLATFORM_SEGA_32X = 'sega32x';
//    const PLATFORM_SEGA_GENESIS = 'gen';
//    const PLATFORM_SEGA_SATURN = 'segasaturn';
//    const PLATFORM_NES = 'nes';
//    const PLATFORM_SNES = 'snes';
//    const PLATFORM_N64 = 'n64';
    const PLATFORM_PLAYSTATION = 'ps1';

    /**
     * @var array of platform to url - key is the platform, value is the url
     */
    protected $_platformToUrl = array(
//        self::PLATFORM_ATARI_2600 => 'http://vgcollect.com/browse/atari2600/21','http://vgcollect.com/browse/atari2600/22', 'http://vgcollect.com/browse/atari2600/23','http://vgcollect.com/browse/atari2600/24', 'http://vgcollect.com/browse/atari2600/25','http://vgcollect.com/browse/atari2600/26', 'http://vgcollect.com/browse/atari2600/27','http://vgcollect.com/browse/atari2600/28', 'http://vgcollect.com/browse/atari2600/29','http://vgcollect.com/browse/atari2600/30', 'http://vgcollect.com/browse/atari2600/31','http://vgcollect.com/browse/atari2600/32'
//        self::PLATFORM_ATARI_5200 => 'http://vgcollect.com/browse/atari5200', 'http://vgcollect.com/browse/atari5200/2', 'http://vgcollect.com/browse/atari5200/3', 'http://vgcollect.com/browse/atari5200/4'
//        self::PLATFORM_ATARI_7800 =>  'http://vgcollect.com/browse/atari7800', 'http://vgcollect.com/browse/atari7800/2', 'http://vgcollect.com/browse/atari7800/3', 'http://vgcollect.com/browse/atari7800/4'
//        self::PLATFORM_ATARI_JAGUAR => 'http://vgcollect.com/browse/jaguar','http://vgcollect.com/browse/jaguar/2','http://vgcollect.com/browse/jaguar/3','http://vgcollect.com/browse/jaguar/4'
//        self::PLATFORM_INTELLIVISION => 'http://vgcollect.com/browse/intellivision', 'http://vgcollect.com/browse/intellivision/2', 'http://vgcollect.com/browse/intellivision/3', 'http://vgcollect.com/browse/intellivision/4', 'http://vgcollect.com/browse/intellivision/5', 'http://vgcollect.com/browse/intellivision/6', 'http://vgcollect.com/browse/intellivision/7', 'http://vgcollect.com/browse/intellivision/8', 'http://vgcollect.com/browse/intellivision/9'
//        self::PLATFORM_COLECOVISION => 'http://vgcollect.com/browse/colecovision', 'http://vgcollect.com/browse/colecovision/2', 'http://vgcollect.com/browse/colecovision/3', 'http://vgcollect.com/browse/colecovision/4', 'http://vgcollect.com/browse/colecovision/5', 'http://vgcollect.com/browse/colecovision/6',
//        self::PLATFORM_COMMODORE_64 => 'http://vgcollect.com/browse/commodore64na', 'http://vgcollect.com/browse/commodore64na/2', 'http://vgcollect.com/browse/commodore64na/3', 'http://vgcollect.com/browse/commodore64na/4', 'http://vgcollect.com/browse/commodore64na/5', 'http://vgcollect.com/browse/commodore64na/6', 'http://vgcollect.com/browse/commodore64na/7', 'http://vgcollect.com/browse/commodore64na/8', 'http://vgcollect.com/browse/commodore64na/9', 'http://vgcollect.com/browse/commodore64na/10', 'http://vgcollect.com/browse/commodore64na/11', 'http://vgcollect.com/browse/commodore64na/12'
//        self::PLATFORM_SEGA_MASTER_SYSTEM => 'http://vgcollect.com/browse/segamastersystem', 'http://vgcollect.com/browse/segamastersystem/2', 'http://vgcollect.com/browse/segamastersystem/3', 'http://vgcollect.com/browse/segamastersystem/4', 'http://vgcollect.com/browse/segamastersystem/5', 'http://vgcollect.com/browse/segamastersystem/6', 'http://vgcollect.com/browse/segamastersystem/7', 'http://vgcollect.com/browse/segamastersystem/8'
//        self::PLATFORM_SEGA_CD => 'http://vgcollect.com/browse/segacdna', 'http://vgcollect.com/browse/segacdna/2', 'http://vgcollect.com/browse/segacdna/3', 'http://vgcollect.com/browse/segacdna/4', 'http://vgcollect.com/browse/segacdna/5', 'http://vgcollect.com/browse/segacdna/6', 'http://vgcollect.com/browse/segacdna/7'
//        self::PLATFORM_SEGA_32X => 'http://vgcollect.com/browse/sega32x', 'http://vgcollect.com/browse/sega32x/2'
//        self::PLATFORM_SEGA_GENESIS => 'http://vgcollect.com/browse/gen', 'http://vgcollect.com/browse/gen/2', 'http://vgcollect.com/browse/gen/3', 'http://vgcollect.com/browse/gen/4', 'http://vgcollect.com/browse/gen/5', 'http://vgcollect.com/browse/gen/6', 'http://vgcollect.com/browse/gen/7', 'http://vgcollect.com/browse/gen/8', 'http://vgcollect.com/browse/gen/9', 'http://vgcollect.com/browse/gen/10', 'http://vgcollect.com/browse/gen/11', 'http://vgcollect.com/browse/gen/12', 'http://vgcollect.com/browse/gen/13', 'http://vgcollect.com/browse/gen/14', 'http://vgcollect.com/browse/gen/15', 'http://vgcollect.com/browse/gen/16', 'http://vgcollect.com/browse/gen/17', 'http://vgcollect.com/browse/gen/18', 'http://vgcollect.com/browse/gen/19', 'http://vgcollect.com/browse/gen/20', 'http://vgcollect.com/browse/gen/21', 'http://vgcollect.com/browse/gen/22', 'http://vgcollect.com/browse/gen/23', 'http://vgcollect.com/browse/gen/24', 'http://vgcollect.com/browse/gen/25', 'http://vgcollect.com/browse/gen/26', 'http://vgcollect.com/browse/gen/27', 'http://vgcollect.com/browse/gen/28', 'http://vgcollect.com/browse/gen/29', 'http://vgcollect.com/browse/gen/30', 'http://vgcollect.com/browse/gen/31', 'http://vgcollect.com/browse/gen/32', 'http://vgcollect.com/browse/gen/33'
//        self::PLATFORM_SEGA_SATURN => 'http://vgcollect.com/browse/segasaturnna', 'http://vgcollect.com/browse/segasaturnna/2', 'http://vgcollect.com/browse/segasaturnna/3', 'http://vgcollect.com/browse/segasaturnna/4', 'http://vgcollect.com/browse/segasaturnna/5', 'http://vgcollect.com/browse/segasaturnna/6', 'http://vgcollect.com/browse/segasaturnna/7', 'http://vgcollect.com/browse/segasaturnna/8', 'http://vgcollect.com/browse/segasaturnna/9', 'http://vgcollect.com/browse/segasaturnna/10', 'http://vgcollect.com/browse/segasaturnna/11'
//        self::PLATFORM_NES => 'http://vgcollect.com/browse/nes', 'http://vgcollect.com/browse/nes/2', 'http://vgcollect.com/browse/nes/3', 'http://vgcollect.com/browse/nes/4', 'http://vgcollect.com/browse/nes/5', 'http://vgcollect.com/browse/nes/6', 'http://vgcollect.com/browse/nes/7', 'http://vgcollect.com/browse/nes/8', 'http://vgcollect.com/browse/nes/9', 'http://vgcollect.com/browse/nes/10', 'http://vgcollect.com/browse/nes/11', 'http://vgcollect.com/browse/nes/12', 'http://vgcollect.com/browse/nes/13', 'http://vgcollect.com/browse/nes/14', 'http://vgcollect.com/browse/nes/15', 'http://vgcollect.com/browse/nes/16', 'http://vgcollect.com/browse/nes/17', 'http://vgcollect.com/browse/nes/18', 'http://vgcollect.com/browse/nes/19', 'http://vgcollect.com/browse/nes/20', 'http://vgcollect.com/browse/nes/21', 'http://vgcollect.com/browse/nes/22', 'http://vgcollect.com/browse/nes/23', 'http://vgcollect.com/browse/nes/24', 'http://vgcollect.com/browse/nes/25', 'http://vgcollect.com/browse/nes/26', 'http://vgcollect.com/browse/nes/27', 'http://vgcollect.com/browse/nes/28', 'http://vgcollect.com/browse/nes/29', 'http://vgcollect.com/browse/nes/30', 'http://vgcollect.com/browse/nes/31', 'http://vgcollect.com/browse/nes/32', 'http://vgcollect.com/browse/nes/33', 'http://vgcollect.com/browse/nes/34', 'http://vgcollect.com/browse/nes/35', 'http://vgcollect.com/browse/nes/36', 'http://vgcollect.com/browse/nes/37', 'http://vgcollect.com/browse/nes/39', 'http://vgcollect.com/browse/nes/39', 'http://vgcollect.com/browse/nes/40', 'http://vgcollect.com/browse/nes/41'
//        self::PLATFORM_SNES => 'http://vgcollect.com/browse/snes', 'http://vgcollect.com/browse/snes/2', 'http://vgcollect.com/browse/snes/3', 'http://vgcollect.com/browse/snes/4', 'http://vgcollect.com/browse/snes/5', 'http://vgcollect.com/browse/snes/6', 'http://vgcollect.com/browse/snes/7', 'http://vgcollect.com/browse/snes/8', 'http://vgcollect.com/browse/snes/9', 'http://vgcollect.com/browse/snes/10', 'http://vgcollect.com/browse/snes/11', 'http://vgcollect.com/browse/snes/12', 'http://vgcollect.com/browse/snes/13', 'http://vgcollect.com/browse/snes/14', 'http://vgcollect.com/browse/snes/15', 'http://vgcollect.com/browse/snes/16', 'http://vgcollect.com/browse/snes/17', 'http://vgcollect.com/browse/snes/18', 'http://vgcollect.com/browse/snes/19', 'http://vgcollect.com/browse/snes/20', 'http://vgcollect.com/browse/snes/21', 'http://vgcollect.com/browse/snes/22', 'http://vgcollect.com/browse/snes/23', 'http://vgcollect.com/browse/snes/24', 'http://vgcollect.com/browse/snes/25', 'http://vgcollect.com/browse/snes/26', 'http://vgcollect.com/browse/snes/27', 'http://vgcollect.com/browse/snes/28', 'http://vgcollect.com/browse/snes/29', 'http://vgcollect.com/browse/snes/30', 'http://vgcollect.com/browse/snes/31', 'http://vgcollect.com/browse/snes/32', 'http://vgcollect.com/browse/snes/33', 'http://vgcollect.com/browse/snes/34', 'http://vgcollect.com/browse/snes/35'
//        self::PLATFORM_N64 => 'http://vgcollect.com/browse/n64', 'http://vgcollect.com/browse/n64/2', 'http://vgcollect.com/browse/n64/3', 'http://vgcollect.com/browse/n64/4', 'http://vgcollect.com/browse/n64/5', 'http://vgcollect.com/browse/n64/6', 'http://vgcollect.com/browse/n64/7', 'http://vgcollect.com/browse/n64/8', 'http://vgcollect.com/browse/n64/9', 'http://vgcollect.com/browse/n64/10', 'http://vgcollect.com/browse/n64/11', 'http://vgcollect.com/browse/n64/12', 'http://vgcollect.com/browse/n64/13', 'http://vgcollect.com/browse/n64/14'
        self::PLATFORM_PLAYSTATION => 'http://vgcollect.com/browse/ps1', 'http://vgcollect.com/browse/ps1/2', 'http://vgcollect.com/browse/ps1/3', 'http://vgcollect.com/browse/ps1/4', 'http://vgcollect.com/browse/ps1/5', 'http://vgcollect.com/browse/ps1/6', 'http://vgcollect.com/browse/ps1/7', 'http://vgcollect.com/browse/ps1/8', 'http://vgcollect.com/browse/ps1/9', 'http://vgcollect.com/browse/ps1/10', 'http://vgcollect.com/browse/ps1/11', 'http://vgcollect.com/browse/ps1/12', 'http://vgcollect.com/browse/ps1/13', 'http://vgcollect.com/browse/ps1/14', 'http://vgcollect.com/browse/ps1/15', 'http://vgcollect.com/browse/ps1/16', 'http://vgcollect.com/browse/ps1/17', 'http://vgcollect.com/browse/ps1/18', 'http://vgcollect.com/browse/ps1/19', 'http://vgcollect.com/browse/ps1/20', 'http://vgcollect.com/browse/ps1/21', 'http://vgcollect.com/browse/ps1/22', 'http://vgcollect.com/browse/ps1/23', 'http://vgcollect.com/browse/ps1/24', 'http://vgcollect.com/browse/ps1/25', 'http://vgcollect.com/browse/ps1/26', 'http://vgcollect.com/browse/ps1/27', 'http://vgcollect.com/browse/ps1/28', 'http://vgcollect.com/browse/ps1/29', 'http://vgcollect.com/browse/ps1/30', 'http://vgcollect.com/browse/ps1/31', 'http://vgcollect.com/browse/ps1/32', 'http://vgcollect.com/browse/ps1/33', 'http://vgcollect.com/browse/ps1/34', 'http://vgcollect.com/browse/ps1/35', 'http://vgcollect.com/browse/ps1/36', 'http://vgcollect.com/browse/ps1/37', 'http://vgcollect.com/browse/ps1/39', 'http://vgcollect.com/browse/ps1/39', 'http://vgcollect.com/browse/ps1/40', 'http://vgcollect.com/browse/ps1/40', 'http://vgcollect.com/browse/ps1/42', 'http://vgcollect.com/browse/ps1/43', 'http://vgcollect.com/browse/ps1/44', 'http://vgcollect.com/browse/ps1/45', 'http://vgcollect.com/browse/ps1/46', 'http://vgcollect.com/browse/ps1/47', 'http://vgcollect.com/browse/ps1/48', 'http://vgcollect.com/browse/ps1/49', 'http://vgcollect.com/browse/ps1/50', 'http://vgcollect.com/browse/ps1/51', 'http://vgcollect.com/browse/ps1/52', 'http://vgcollect.com/browse/ps1/53', 'http://vgcollect.com/browse/ps1/54', 'http://vgcollect.com/browse/ps1/55', 'http://vgcollect.com/browse/ps1/56', 'http://vgcollect.com/browse/ps1/57', 'http://vgcollect.com/browse/ps1/58', 'http://vgcollect.com/browse/ps1/59', 'http://vgcollect.com/browse/ps1/60', 'http://vgcollect.com/browse/ps1/61', 'http://vgcollect.com/browse/ps1/62', 'http://vgcollect.com/browse/ps1/63', 'http://vgcollect.com/browse/ps1/64', 'http://vgcollect.com/browse/ps1/65', 'http://vgcollect.com/browse/ps1/66', 'http://vgcollect.com/browse/ps1/67', 'http://vgcollect.com/browse/ps1/68', 'http://vgcollect.com/browse/ps1/69'
    );

    /**
     * The run command initializes the scraper
     *
     * @param null $platform a constant from our class to say which platform or null for all
     * @throws Exception
     */
    public function run($platform = null)
    {
        $platformsToRun = array();
        if (is_null($platform)) {
            $platformsToRun = $this->_platformToUrl;
        }
        elseif (isset($this->_platformToUrl[$platform])) {
            $platformsToRun[$platform] = $this->_platformToUrl[$platform];
        }
        else {
            throw new Exception($platform . ' is not a valid platform to scrape.');
        }

        $values = $this->_scrape($platformsToRun);

        $this->_outputToCsvFile($values);

        $this->_output('Done parsing.', self::OUTPUT_FINISH);
    }

    /**
     * Our actual scraper
     * @param $platforms the platforms to run
     * @return array the scraped information
     */
    protected function _scrape($platforms)
    {
        $values = array();

        // stop being so preachy
        libxml_use_internal_errors(true);

        foreach ($platforms as $platformName => $platformUrl) {
            $this->_output("Retrieving {$platformName} using {$platformUrl}: ", self::OUTPUT_BEGIN);

            $dom = $this->_getADomFromUrl($platformUrl);
            if (!$dom) {
                break;
            }
            $this->_output('got it.', self::OUTPUT_FINISH);

            $xpath = new DOMXPath($dom);
            $query = '//*[contains(@class,"item-name")]/a';

            $aTags = $xpath->query($query);

            $itemsArrayFromPage = array();

            foreach ($aTags as $aTag) {
                $title = $aTag->nodeValue;
                $url = $aTag->getAttribute('href');
                $this->_output("Getting {$title} from {$url}: ", self::OUTPUT_BEGIN);

                $individualGameDom = $this->_getADomFromUrl($url);
                if (!$individualGameDom) {
                    $this->_output('that failed.', self::OUTPUT_FINISH);
                    break;
                }

                $itemsArrayFromPage[] = $this->_retrieveItemsFromIndividualGameDom($individualGameDom);
                $this->_output('got it.', self::OUTPUT_FINISH);

            }

            $values[$platformName] = $itemsArrayFromPage;

        }

        return $values;
    }

    /**
     * Writes the array to a file
     *
     * @param $values
     */
    protected function _outputToCsvFile($values)
    {
        $output = array();
        $output[] = array('Platform', 'title', 'developer', 'publisher', 'genre', 'rating', 'release date', 'cover image url');
        foreach ($values as $platform=>$gameArray) {
            foreach ($gameArray as $gameInfo) {
                $output[] = array($platform, $gameInfo['title'], $gameInfo['developer'], $gameInfo['publisher'], $gameInfo['genre'], $gameInfo['rating'], $gameInfo['release date'], $gameInfo['cover image']);
            }
        }

        $file = fopen(self::OUTPUT_FILE, 'w');
        foreach ($output as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        $this->_output('Wrote to file ' . self::OUTPUT_FILE, self::OUTPUT_FINISH);

    }

    /**
     * This will parse the individual page.
     *
     * note: some of this is repetitive - but that's because the elements change between attribute and node value
     *
     * @param DOMDocument $dom
     * @return keyed array of items retrieved
     */
    protected function _retrieveItemsFromIndividualGameDom(DOMDocument $dom)
    {
        $returnArray = array();

        $xpath = new DOMXPath($dom);

        // retrieve the title
        $query = '//div[@class="main_header"]/h2';
        $titleTagList = $xpath->query($query);
        $titleTag = $titleTagList->item(0);
        $returnArray['title'] = trim(preg_replace('/\s+/', ' ', $titleTag->nodeValue));

        //developer
        $query = '//td[preceding-sibling::td=" Developer(s):"]';
        $developerTagList = $xpath->query($query);
        $developerTag = $developerTagList->item(0);
        $returnArray['developer'] = trim(preg_replace('/\s+/', ' ', $developerTag->nodeValue));

        //publisher
        $query = '//td[preceding-sibling::td="Publisher(s):"]';
        $publisherTagList = $xpath->query($query);
        $publisherTag = $publisherTagList->item(0);
        $returnArray['publisher'] = trim(preg_replace('/\s+/', ' ', $publisherTag->nodeValue));

        //genre
        $query = '//td[preceding-sibling::td="Genre:"]';
        $genreTagList = $xpath->query($query);
        $genreTag = $genreTagList->item(0);
        $returnArray['genre'] = trim(preg_replace('/\s+/', ' ', $genreTag->nodeValue));

        //rating
        $query = '//td[preceding-sibling::td="Rating:"]';
        $ratingTagList = $xpath->query($query);
        $ratingTag = $ratingTagList->item(0);
        $returnArray['rating'] = trim(preg_replace('/\s+/', ' ', $ratingTag->nodeValue));

        //release date
        $query = '//td[preceding-sibling::td="Release Date:"]';
        $releaseDateTagList = $xpath->query($query);
        $releaseDateTag = $releaseDateTagList->item(0);
        $returnArray['release date'] = trim(preg_replace('/\s+/', ' ', $releaseDateTag->nodeValue));

        // retrieve the cover image
        $query = '//div[@id="item-image-front"]/img';
        $imgTagList = $xpath->query($query);
        $imgTag = $imgTagList->item(0);
        $returnArray['cover image'] = $imgTag->getAttribute('src');

        return $returnArray;
    }

    /**
     * Gets a dom or returns false
     * @param $url the url to retrieve
     * @return mixed
     */
    protected function _getADomFromUrl($url)
    {
        $page = file_get_contents($url);
        if ($page === false) {
            $this->_output('was not able to retrieve it.', self::OUTPUT_FINISH);
            return false;
        }

        $dom = new DomDocument();
        if (!$dom->loadHTML($page)) {
            $this->_output('was not able to parse the output into dom.', self::OUTPUT_FINISH);
            return false;
        }

        return $dom;
    }

    /**
     * Displays message to the user
     *
     * @param $message
     * @param $type
     */
    protected function _output($message, $type)
    {
        echo $message;
        if ($type == self::OUTPUT_FINISH) {
            echo "\n";
        }
    }
}

// no time limit
set_time_limit(0);

$scraper = new Scraper();
$scraper->run();