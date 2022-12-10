# trdizingetir
displays article data if trdizin article number is known

fetches utf-8 html form url

```
    $opts = array('http' => array('header' => 'Accept-Charset: UTF-8, *;q=0'));
    $context = stream_context_create($opts);
    $html=file_get_contents($url, false, $context);
```


reads metadata from
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

displays metadata


