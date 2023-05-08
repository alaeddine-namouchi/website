<?php

?>
<head>
  <title>TRANSTU</title>
<!-- Page francophone  -->
  <link rel="alternate" hreflang="fr"
        href="http://localhost/transtu/ar/" />
<!-- La même page, en anglais  -->
  <link rel="alternate" hreflang="ar"
        href="http://localhost/transtu/ar/" />
<!-- Et si la langue n'est pas prise en charge, la page par défaut est alors la page d'index  -->
  <link rel="alternate" hreflang="x-default"
        href="ar/" />
</head>
<script>
if (navigator.browserLanguage)
var language = navigator.browserLanguage;
else
var language = navigator.language;
                    
if (language.indexOf('ar') > -1) document.location.href = 'ar';
if (language.indexOf('fr') > -1) document.location.href = 'fr';
else if (language.indexOf('fr') > -1) document.location.href = 'fr';
else
document.location.href = 'fr/';
</script>