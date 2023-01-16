SELECT count(id) as count_urls FROM urls
UNION
SELECT count(url_id) 
	FROM (
		SELECT url_id 
		FROM urls_headers uh 
		WHERE uh.`key` = 'new' AND uh.`value` = '1'
	) urls