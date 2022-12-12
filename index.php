<!DOCTYPE html>
<!-- trdizin getir V1.1: bu yazılım Dr. Zafer Akçalı tarafından oluşturulmuştur 
programmed by Zafer Akçalı, MD -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trdizin numarasından makaleyi bul</title>
</head>

<body>
<?php
// trdizin getir
// By Zafer Akçalı, MD
// Zafer Akçalı tarafından programlanmıştır
$trdizinid=$doi=$ArticleTitle=$dergi=$ISOAbbreviation=$ISSN=$eISSN=$Year=$Volume=$Issue=$StartPage=$EndPage=$yazarlar=$PublicationType=$AbstractText=$dergiLinki=$ArticleType="";
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
$belgeMeta='Belge Türü:</span>';
$makaleMeta='Makale Türü:</span>';
$dergiMeta='http://search/dergi/detay/';
if (isset($_POST['trdizinid'])) {
$gelenTrdizin=preg_replace("/[^0-9]/", "", $_POST["trdizinid"] ); // sadece rakamlar

if($gelenTrdizin!=""){
$preText="https://search.trdizin.gov.tr/yayin/detay/";
$url = $preText.$gelenTrdizin;
// echo ($url);
// echo ("<br>");

// https://www.scrapingbee.com/blog/web-scraping-php/
$icerik=file_get_contents($url);
// On Windows, uncomment the following line in php.ini, and restart the Apache server:
// extension=mbstring
// extension=php_mbstring.dll
$html= mb_convert_encoding($icerik, 'HTML-ENTITIES', "UTF-8");
// echo $html;

// print_r ($trdizinBilgi);
if ( true) {// hata kontrolü yapmak gerek ??
// Makalenin başlığı
if (stripos($html,$titleMeta)) {
	$start = stripos($html, $titleMeta)+strlen($titleMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$ArticleTitle = substr($html, $start, $length);
	}
// yayın türü
if (stripos($html,$belgeMeta)) {
	$start = stripos($html, $belgeMeta)+strlen($belgeMeta);
	$end= stripos($html,'</span>',$offset = $start );
	$length = $end - $start;
	$PublicationType = trim (substr($html, $start, $length));
	}
// makale türü
if (stripos($html,$makaleMeta)) {
	$start = stripos($html, $makaleMeta)+strlen($makaleMeta);
	$end= stripos($html,'</span>',$offset = $start );
	$length = $end - $start;
	$ArticleType = trim (substr($html, $start, $length));
	}
// Özet
if (stripos($html,$abstractMeta)) {
	$start = stripos($html, $abstractMeta)+strlen($abstractMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$AbstractText = substr($html, $start, $length);
	}
// doi
if (stripos($html,$doiMeta)) {
	$start = stripos($html, $doiMeta)+strlen($doiMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$doi = substr($html, $start, $length);
	}
// PMID
if (isset($trdizinBilgi['abstracts-retrieval-response']['coredata']['pubmed-id']))
	$PMID= $trdizinBilgi['abstracts-retrieval-response']['coredata']['pubmed-id'];
// trdizin numarası
if (stripos($html,$trdizinMeta)) {
	$start = stripos($html, $trdizinMeta)+strlen($trdizinMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$trdizinid = substr($html, $start, $length);
	}
// Dergi ismi
if (stripos($html,$journalMeta)) {
	$start = stripos($html, $journalMeta)+strlen($journalMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$dergi = substr($html, $start, $length);
	}
// Dergi linki
if (stripos($html,$dergiMeta)) {
	$start = stripos($html, $dergiMeta)+strlen($dergiMeta);
	$end= stripos($html,'"',$offset = $start );
	$length = $end - $start;
	$dergiLinki = substr($html, $start, $length);
	}
	
// Aldığı atıf sayısı
if (isset ($trdizinBilgi['abstracts-retrieval-response']['coredata']['citedby-count']))
	$atif=$trdizinBilgi['abstracts-retrieval-response']['coredata']['citedby-count'];

// dergi kısa ismi
// $ISOAbbreviation = $trdizinBilgi['source']['abbreviatedSourceTitle'];

// issn
if (stripos($html,$issnMeta)) {
	$start = stripos($html, $issnMeta)+strlen($issnMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$ISSN = substr($html, $start, $length);
	}
// Derginin basıldığı / yayımlandığı yıl
if (stripos($html,$yearMeta)) {
	$start = stripos($html, $yearMeta)+strlen($yearMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$Year = substr($html, $start, $length);
	}
// cilt
if (stripos($html,$volumeMeta)) {
	$start = stripos($html, $volumeMeta)+strlen($volumeMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$Volume = substr($html, $start, $length);
	}
// sayı
if (stripos($html,$issueMeta)) {
	$start = stripos($html, $issueMeta)+strlen($issueMeta);
	$end= stripos($html,'" />',$offset = $start );
	$length = $end - $start;
	$Issue = substr($html, $start, $length);
	}
// başlangıç sayfası
if (stripos($html,$ilksayfaMeta)) {
	$start = stripos($html, $ilksayfaMeta)+strlen($ilksayfaMeta);
	$end= stripos($html,'",',$offset = $start );
	$length = $end - $start;
	$StartPage = substr($html, $start, $length);
	}
// bitiş sayfası
if (stripos($html,$sonsayfaMeta)) {
	$start = stripos($html, $sonsayfaMeta)+strlen($sonsayfaMeta);
	$end= stripos($html,'",',$offset = $start );
	$length = $end - $start;
	$EndPage = substr($html, $start, $length);
	}
// yazarlar
$yazarlar="";
// yazar sayısı
$yazarS=0;

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
	$yazarlar=$yazarlar.$isim." ".$soyisim.", ";
	$yazarS=$yazarS+1;

  }
}
$yazarlar=substr ($yazarlar,0,-2);
		} // {"message":"Forbidden"} hatası gelmedi
	} 
}
?>
<a href="trdizin id nerede.png" target="_blank"> Trdizin numarasına nereden bakılır? </a>
<form method="post" action="">
Trdizin makale numarasını giriniz<br/>
<input type="text" name="trdizinid" id="trdizinid" value="<?php echo $trdizinid;?>" >
<input type="submit" value="Trdizin yayın bilgilerini PHP ile getir">
</form>
<button id="trDizinGoster" onclick="trDizinGoster()">Trdizin yayınını göster</button>
<button id="trDizinAtifGoster" onclick="trDizinAtifGoster()">Trdizin yayınının atıflarını göster</button>
<button id="doiGit" onclick="doiGit()">doi ile makaleyi göster</button>
<button id="dergiGit" onclick="dergiGit()">Dergiyi gör</button>
<br/>
Trdizin id: <input type="text" name="eid" size="25" id="eid" value="<?php echo $trdizinid;?>" >  
doi: <input type="text" name="doi" size="55"  id="doi" value="<?php echo $doi;?>"> <br/>
Makalenin başlığı: <input type="text" name="ArticleTitle" size="85"  id="ArticleTitle" value="<?php echo $ArticleTitle;?>"> <br/>
Dergi ismi: <input type="text" name="Title" size="50"  id="Title" value="<?php echo $dergi;?>"> 
Kısa ismi: <input type="text" name="ISOAbbreviation" size="26"  id="ISOAbbreviation" value="<?php echo $ISOAbbreviation;?>"> <br/>
ISSN: <input type="text" name="ISSN" size="8"  id="ISSN" value="<?php echo $ISSN;?>">
eISSN: <input type="text" name="eISSN" size="8"  id="eISSN" value="<?php echo $eISSN;?>">
<br/>
Yıl: <input type="text" name="Year" size="4"  id="Year" value="<?php echo $Year;?>">
Cilt: <input type="text" name="Volume" size="2"  id="Volume" value="<?php echo $Volume;?>">
Sayı: <input type="text" name="Issue" size="2"  id="Issue" value="<?php echo $Issue;?>">
Sayfa/numara: <input type="text" name="StartPage" size="5"  id="StartPage" value="<?php echo $StartPage;?>">
- <input type="text" name="EndPage" size="2"  id="EndPage" value="<?php echo $EndPage;?>">
Yazar sayısı: <input type="text" name="yazarS" size="2"  id="yazarS" value="<?php echo $yazarS;?>"><br/>
Yazarlar: <input type="text" name="yazarlar" size="95"  id="yazarlar" value="<?php echo $yazarlar;?>"><br/>
Yayın türü: <input type="text" name="PublicationType" size="10"  id="PublicationType" value="<?php echo $PublicationType;?>">
Makale türü: <input type="text" name="ArticleType" size="15"  id="ArticleType" value="<?php echo $ArticleType;?>">
Dergi numarası: <input type="text" name="dergiLinki" size="10"  id="dergiLinki" value="<?php echo $dergiLinki;?>">
<br/>
Özet <br/>
<textarea rows = "20" cols = "90" name = "ozet" id="ozetAlan"><?php echo $AbstractText;?></textarea>  <br/>
<script>
function trDizinGoster() {
var	w=document.getElementById('eid').value.replace('2-s2.0-','');
	urlText = "https://search.trdizin.gov.tr/yayin/detay/" + w;
	window.open(urlText,"_blank");
}
function trDizinAtifGoster() {
var	w=document.getElementById('eid').value;
	urlText = "https://search.trdizin.gov.tr/yayin/detay/"+w+"/#publications";
	window.open(urlText,"_blank");
}
function doiGit() {
var	w=document.getElementById('doi').value;
	urlText = "https://doi.org/"+w;
	window.open(urlText,"_blank");
}
function dergiGit() {
var	w=document.getElementById('dergiLinki').value;
	urlText = 'https://search.trdizin.gov.tr/dergi/detay/'+w;
	window.open(urlText,"_blank");
}
</script>
</body>
</html>
