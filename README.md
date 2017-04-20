Fam UserAgentParser
---

Fam UserAgentParser is a lightweight and fast browser detector. It determines the operating system, web client name and web client version.

---

<img src="https://api.travis-ci.org/dspasic/Fam.svg" title="build status for Fam"> 
[![Code Coverage](https://scrutinizer-ci.com/g/dspasic/Fam/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/dspasic/Fam/?branch=master) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dspasic/Fam/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dspasic/Fam/?branch=master) 

---

### Installing 

You can install Fam UserAgentParser with [composer](https://getcomposer.org/). To install Fam UserAgentParser with 
composer just execute the following command:

```bash
composer require fam/util-useragentparser
```

## Getting started
```php
$userAgent = UserAgentParser::createInstance()->parseUserAgent($_SERVER['HTTP_USER_AGENT']);

if ($userAgent->isWebClient('firefox')) {
    if (UserAgentParser::isWebClientVersionBetween(9.5, 9.6)) {
       echo 'firefox between 95 and 96';
    }
    else if (UserAgentParser::isWebClientVersionBetween(9.2, 9.4)) {
       echo 'firefox between 92 and 94';
    }
}

if ($userAgent->isOs('macintosh')) {
   echo 'Mac';
}
```

