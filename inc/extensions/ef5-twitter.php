<?php
add_filter(
	'ef5systems_twitter_api_consumer_key', 
	function(){
		return overcome_get_theme_opt(
			'twitter_api_consumer_key',
			'i90SevLFwZDscXPo3Wj89Y4eO'
		);
	}
);

add_filter(
	'ef5systems_twitter_api_consumer_secret', 
	function(){
		return overcome_get_theme_opt(
			'twitter_api_consumer_secret',
			'61AmOoAxacZeQneXjCOzKZGRwXwcRFgMsIhhYnQ5JTAOvMdlmL'
		);
	}
);
add_filter(
	'ef5systems_twitter_api_access_key',
	function(){
		return overcome_get_theme_opt(
			'twitter_api_access_key',
			'107960275-v9RLlUdpW7xW0wbh0Xtg8X2mVFbaCDtFNAs8vwAc'
		);
	}
);
add_filter(
	'ef5systems_twitter_api_access_secret', 
	function(){
		return overcome_get_theme_opt(
			'twitter_api_access_secret',
			'VewAXAcJEyDpqlrDfDO40HbRq6rzkYPEHgXz3WNhxAbSv'
		);
	}
);