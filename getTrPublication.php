<?php
class getTrPublication {
	    function __construct() {
			$this->initialize();
		}
		function initialize () {
			$this->trdizinid=''; $this->doi=''; $this->ArticleTitle=''; $this->dergi=''; $this->ISSN=''; $this->eISSN=''; $this->Year=''; $this->Volume=''; $this->Issue=''; $this->StartPage=''; $this->EndPage=''; $this->yazarlar=''; $this->PublicationType=''; $this->AbstractText='';$this->dergiLinki=''; $this->ArticleType=''; $this->dikkat='';
			$this->yazarS=0; 
		}
			
		final function trPublication ($numara) {
		$this->initialize();
			
		$volumeMeta='meta name="DC.Source.Volume" content="';
		$issueMeta='meta name="DC.Source.Issue" content="';
		$issnMeta='<meta name="DC.Source.ISSN" content="';
		$titleMeta='meta name="DC.Title" content="';
		$journalMeta='meta name="citation_journal_title" content="';
		$abstractMeta='meta name="citation_abstract" content="';
		$trdizinMeta='"DC.Identifier" content="';
		$yearMeta='meta name="citation_publication_date" content="';
		$doiMeta='<meta name="citation_doi" content="';
		$ilksayfaMeta='"pageStart": "';
		$sonsayfaMeta='"pageEnd": "';
		$belgeMeta='Belge T'; // Belge Türü, Türkçe karakter olmadan
		$makaleMeta='Makale T'; // Makale Türü, Türkçe karakter olmadan
		$dergiMeta='http://search/dergi/detay/';

		$preText="https://search.trdizin.gov.tr/yayin/detay/";
		$url = $preText.$numara;
// echo ($url);
// echo ("<br>");
	$headers = @get_headers($url);	
	if (!$headers) {
			$this->dikkat='bağlantı kurulamadı';   
			return;
			}
	if(substr($headers[0], 9, 3) != "200") {
		$this->dikkat='yayın bulunamadı';   
		return;
		}	
// https://www.scrapingbee.com/blog/web-scraping-php/
	$icerik=@file_get_contents($url);

// On Windows, uncomment the following line in php.ini, and restart the Apache server:
// extension=mbstring
// extension=php_mbstring.dll
		$html= mb_convert_encoding($icerik, 'HTML-ENTITIES', "UTF-8");
// echo $html;

// print_r ($trdizinBilgi);
// Makalenin başlığı
			if (stripos($html,$titleMeta)) {
				$start = stripos($html, $titleMeta)+strlen($titleMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->ArticleTitle = substr($html, $start, $length);
				}
// yayın türü
			if (stripos($html,$belgeMeta)) {
				$start = stripos($html, $belgeMeta)+strlen($belgeMeta)+21; // Türkçe karakter atlama sorunu sebebiyle 21 karakter
				$end= stripos($html,'</span>',$offset = $start );
				$length = $end - $start;
				$this->PublicationType = trim (substr($html, $start, $length));
			}
// makale türü
			if (stripos($html,$makaleMeta)) {
				$start = stripos($html, $makaleMeta)+strlen($makaleMeta)+21; // Türkçe karakter atlama sorunu sebebiyle 21 karakter
				$end= stripos($html,'</span>',$offset = $start );
				$length = $end - $start;
				$this->ArticleType = trim (substr($html, $start, $length));
				}
// Özet
			if (stripos($html,$abstractMeta)) {
				$start = stripos($html, $abstractMeta)+strlen($abstractMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->AbstractText = substr($html, $start, $length);
				}
// doi
			if (stripos($html,$doiMeta)) {
				$start = stripos($html, $doiMeta)+strlen($doiMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->doi = substr($html, $start, $length);
				}
// PMID
			if (isset($trdizinBilgi['abstracts-retrieval-response']['coredata']['pubmed-id']))
				$this->PMID= $trdizinBilgi['abstracts-retrieval-response']['coredata']['pubmed-id'];
// trdizin numarası
			if (stripos($html,$trdizinMeta)) {
				$start = stripos($html, $trdizinMeta)+strlen($trdizinMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->trdizinid = substr($html, $start, $length);
				}
// Dergi ismi
			if (stripos($html,$journalMeta)) {
				$start = stripos($html, $journalMeta)+strlen($journalMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->dergi = substr($html, $start, $length);
				}
// Dergi linki
			if (stripos($html,$dergiMeta)) {
				$start = stripos($html, $dergiMeta)+strlen($dergiMeta);
				$end= stripos($html,'"',$offset = $start );
				$length = $end - $start;
				$this->dergiLinki = substr($html, $start, $length);
				}
	
// Aldığı atıf sayısı
			if (isset ($trdizinBilgi['abstracts-retrieval-response']['coredata']['citedby-count']))
				$this->atif=$trdizinBilgi['abstracts-retrieval-response']['coredata']['citedby-count'];

// dergi kısa ismi
// $ISOAbbreviation = $trdizinBilgi['source']['abbreviatedSourceTitle'];

// issn
			if (stripos($html,$issnMeta)) {
				$start = stripos($html, $issnMeta)+strlen($issnMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->ISSN = substr($html, $start, $length);
				}
// Derginin basıldığı / yayımlandığı yıl
			if (stripos($html,$yearMeta)) {
				$start = stripos($html, $yearMeta)+strlen($yearMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->Year = substr($html, $start, $length);
				}
// cilt
			if (stripos($html,$volumeMeta)) {
				$start = stripos($html, $volumeMeta)+strlen($volumeMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->Volume = substr($html, $start, $length);
				}
// sayı
			if (stripos($html,$issueMeta)) {
				$start = stripos($html, $issueMeta)+strlen($issueMeta);
				$end= stripos($html,'" />',$offset = $start );
				$length = $end - $start;
				$this->Issue = substr($html, $start, $length);
				}
// başlangıç sayfası
			if (stripos($html,$ilksayfaMeta)) {
				$start = stripos($html, $ilksayfaMeta)+strlen($ilksayfaMeta);
				$end= stripos($html,'",',$offset = $start );
				$length = $end - $start;
				$this->StartPage = substr($html, $start, $length);
				}
// bitiş sayfası
			if (stripos($html,$sonsayfaMeta)) {
				$start = stripos($html, $sonsayfaMeta)+strlen($sonsayfaMeta);
				$end= stripos($html,'",',$offset = $start );
				$length = $end - $start;
				$this->EndPage = substr($html, $start, $length);
				}
// yazarlar
			$this->yazarlar="";
// yazar sayısı
			$this->yazarS=0;

// https://stackoverflow.com/questions/6113716/getting-meta-title-and-description
			$doc = new DOMDocument();
// squelch HTML5 errors
			@$doc->loadHTML($html);
			$metas = $doc->getElementsByTagName('meta');
			foreach ($metas as $meta) {
				if (strtolower($meta->getAttribute('name')) == 'citation_author') {
					$ad = $meta->getAttribute('content');
					$soyadAd=explode (", ", $ad);
					$soyisim=$soyadAd[0];
					$isim=$soyadAd[1];
					$this->yazarlar=$this->yazarlar.$isim." ".$soyisim.", ";
					$this->yazarS=$this->yazarS+1;
					}
				}
			$this->yazarlar=substr ($this->yazarlar,0,-2);
	} // final function trPublication

}