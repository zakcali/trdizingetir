<!DOCTYPE html>
<!-- trdizin getir V2.2: bu yazılım Dr. Zafer Akçalı tarafından oluşturulmuştur 
programmed by Zafer Akçalı, MD -->
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trdizin numarasından makaleyi bul</title>
</head>

<body>
<?php
// By Zafer Akçalı, MD
// Zafer Akçalı tarafından programlanmıştır
require_once 'getTrPublication.php';
$t=new getTrPublication ();

if (isset($_POST['trdizinid'])) {
$gelenTrdizin=preg_replace("/[^0-9]/", "", $_POST["trdizinid"] ); // sadece rakamlar
$t->trPublication ($gelenTrdizin);
}
?>
<a href="trdizin id nerede.png" target="_blank"> Trdizin numarasına nereden bakılır? </a>
<form method="post" action="">
Trdizin makale numarasını giriniz. <?php echo ' '.$t->dikkat;?><br/>
<input type="text" name="trdizinid" id="trdizinid" value="<?php echo $t->trdizinid;?>" >
<input type="submit" value="Trdizin yayın bilgilerini PHP ile getir">
</form>
<button id="trDizinGoster" onclick="trDizinGoster()">Trdizin yayınını göster</button>
<button id="trDizinAtifGoster" onclick="trDizinAtifGoster()">Trdizin yayınının atıflarını göster</button>
<button id="doiGit" onclick="doiGit()">doi ile makaleyi göster</button>
<button id="dergiGit" onclick="dergiGit()">Dergiyi gör</button>
<br/>
Trdizin id: <input type="text" name="eid" size="25" id="eid" value="<?php echo $t->trdizinid;?>" >  
doi: <input type="text" name="doi" size="55"  id="doi" value="<?php echo $t->doi;?>"> <br/>
Başlık: <input type="text" name="ArticleTitle" size="96"  id="ArticleTitle" value="<?php echo str_replace ('"',  '&#34',$t->ArticleTitle);?>"> <br/>
Dergi ismi: <input type="text" name="Title" size="50"  id="Title" value="<?php echo $t->dergi;?>"> 
Kısa ismi: <input type="text" name="ISOAbbreviation" size="26"  id="ISOAbbreviation" value="<?php echo $t->ISOAbbreviation;?>"> <br/>
ISSN: <input type="text" name="ISSN" size="8"  id="ISSN" value="<?php echo $t->ISSN;?>">
eISSN: <input type="text" name="eISSN" size="8"  id="eISSN" value="<?php echo $t->eISSN;?>">
<br/>
Yıl: <input type="text" name="Year" size="4"  id="Year" value="<?php echo $t->Year;?>">
Cilt: <input type="text" name="Volume" size="2"  id="Volume" value="<?php echo $t->Volume;?>">
Sayı: <input type="text" name="Issue" size="2"  id="Issue" value="<?php echo $t->Issue;?>">
Sayfa/numara: <input type="text" name="StartPage" size="5"  id="StartPage" value="<?php echo $t->StartPage;?>">
- <input type="text" name="EndPage" size="2"  id="EndPage" value="<?php echo $t->EndPage;?>">
Yazar sayısı: <input type="text" name="yazarS" size="2"  id="yazarS" value="<?php echo $t->yazarS;?>"><br/>
Yazarlar: <input type="text" name="yazarlar" size="95"  id="yazarlar" value="<?php echo $t->yazarlar;?>"><br/>
Yayın türü: <input type="text" name="PublicationType" size="10"  id="PublicationType" value="<?php echo $t->PublicationType;?>">
Makale türü: <input type="text" name="ArticleType" size="15"  id="ArticleType" value="<?php echo $t->ArticleType;?>">
Dergi numarası: <input type="text" name="dergiLinki" size="10"  id="dergiLinki" value="<?php echo $t->dergiLinki;?>">
<br/>
Özet <br/>
<textarea rows = "20" cols = "90" name = "ozet" id="ozetAlan"><?php echo $t->AbstractText;?></textarea>  <br/>
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
