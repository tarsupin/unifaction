<?hh if(!defined("CONF_PATH")) { die("No direct script access allowed."); } /*

------------------------------------------
------ About the AppHomeFeed Plugin ------
------------------------------------------

This plugin allows you to handle the front page of UniFaction.

*/

abstract class AppHomeFeed {
	
	
/****** Get a single entry ******/
	public static function get
	(
		int $entryID		// <int> The ID of the entry to retrieve.
	): array <str, mixed>					// RETURNS <str:mixed> a list of the content IDs based on recent posts.
	
	// $entryData = AppHomeFeed::get($entryID);
	{
		return Database::selectOne("SELECT * FROM home_content c LEFT JOIN users u ON c.uni_id=u.uni_id WHERE id=? LIMIT 1", array($entryID));
	}
	
	
/****** Get the feed data for the home page ******/
	public static function getFeed (
		int $startPage = 1		// <int> The starting page.
	,	int $rowsPerPage = 15	// <int> The number of entries to return per page.
	): array <int, array<str, mixed>>					// RETURNS <int:[str:mixed]> a list of the content IDs based on recent posts.
	
	// $feedData = AppHomeFeed::getFeed();
	{
		return Database::selectMultiple("SELECT c.*, u.handle, u.display_name FROM home_content c LEFT JOIN users u ON c.uni_id=u.uni_id ORDER BY id DESC LIMIT " . (($startPage - 1) * $rowsPerPage) . ", " . ($rowsPerPage + 0), array());
	}
	
	
/****** Add a new entry to the home page ******/
	public static function insert
	(
		int $uniID			// <int> The UniID of the author.
	,	string $url			// <str> The URL of where the article resides.
	,	string $title			// <str> The title of the article.
	,	string $description	// <str> The description of the article.
	,	string $primaryHashtag	// <str> The primary hashtag of the article.
	,	array <int, str> $hashtagList	// <int:str> A list of hashtags that the article used.
	,	string $thumbnail		// <str> The URL for the thumbnail of the image.
	): bool					// RETURNS <bool> TRUE on success, FALSE on failure.s
	
	// $entryData = AppHomeFeed::insert($uniID, $url, $title, $description, $primaryHashtag, $hashtagList, $thumbnail);
	{
		$hashtagStr = implode(" ", $hashtagList);
		
		return Database::query("INSERT INTO home_content (date_posted, uni_id, url, title, description, primary_hashtag, hashtags, thumbnail) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(time(), $uniID, $url, $title, $description, $primaryHashtag, $hashtagStr, $thumbnail));
	}
	
	
/****** Pull an article from a URL ******/
	public static function pullArticleFromURL
	(
		string $articleURL		// <str> The URL to pull an article from to post to the home page.
	): int					// RETURNS <int> The queue ID that was saved after a successful pull, or 0 on failure.
	
	// AppHomeFeed::pullArticleFromURL($articleURL);
	{
		// Parse the URL for data
		$urlParse = URL::parse($_POST['home_url']);
		
		// Prepare the Packet
		$packet = array(
			"url_slug"		=> $urlParse['path']
		);
		
		// Run the API
		if($response = Connect::call("http://" . $urlParse['host'] . "/api/ScrapeDataAPI", $packet, ""))
		{
			return AppHomeFeed::insert((int) $response['uni_id'], trim($response['url'], "/") . '/' . $response['url_slug'], $response['title'], $response['description'], $response['primary_hashtag'], $response['hashtag_list'], $response['thumbnail']);
		}
		
		return 0;
	}
	
	
/****** Output a content feed ******/
	public static function displayFeed
	(
		array <int, array<str, mixed>> $feedData			// <int:[str:mixed]> The array that contains the content entry IDs for the feed.
	,	bool $doTracking = true	// <bool> TRUE if we're going to show the tracking row.
	,	int $uniID = 0			// <int> The UniID viewing the feed, if applicable.
	): void						// RETURNS <void> outputs the appropriate line.
	
	// AppHomeFeed::displayFeed($feedData, [$doTracking], [$uniID]);
	{
		// Make sure Content IDs are available
		if(!$feedData)
		{
			echo '<p style="margin-top:16px; margin-bottom:0px">No articles available here at this time.</p>'; return;
		}
		
		// Prepare Values
		$socialURL = URL::unifaction_social();
		$hashtagURL = URL::hashtag_unifaction_com();
		
		// Pull the necessary feed data
		//$feedData = self::scanFeed($feedData, $doTracking, $uniID);
		
		// Loop through the content entries in the feed
		// Looping with the $feedData variable allow us to maintain the proper ordering
		foreach($feedData as $fd)
		{
			$contentID = (int) $fd['id'];
			
			// Display the Content
			echo '
			<hr class="c-hr" />
			<div class="c-feed-wrap">
				<div class="c-feed-left">';
			
			// If we have a thumbnail version of the image, use that one
			if($fd['thumbnail'])
			{
				echo '<a href="' . $fd['url'] . '">' . Photo::responsive($fd['thumbnail'], "", 950, "", 950, "c-feed-img") . '</a>';
			}
			
			echo '
				</div>
				<div class="c-feed-right">
					<div class="c-feed-date feed-desktop">' . date("m/j/y", $fd['date_posted']) . '</div>
					<div class="c-feed-title"><a href="' . $fd['url'] . '">' . $fd['title'] . '</a></div>';
			
			if($fd['handle'])
			{
				echo '
					<div class="c-feed-author feed-desktop">Written by <a href="' . $socialURL . '/' . $fd['handle'] . '">' . $fd['display_name'] . '</a> (<a href="' . $socialURL . '/' . $fd['handle'] . '">@' . $fd['handle'] . '</a>)</div>';
			}
			
			echo '
					<div class="c-feed-body">' . $fd['description'] . '</div>';
			
			// Hashtag List
			if($fd['primary_hashtag'])
			{
				echo '
					<div class="c-tag-wrap">
						<div class="c-tag-prime">
							<div class="c-tp-plus">
								<a class="c-tp-plink" href="' . Feed::follow($fd['primary_hashtag']) . '"><span class="icon-circle-plus"></span></a>
							</div>
							<a class="c-hlink" href="' . $hashtagURL . '/' . $fd['primary_hashtag'] . '">#' . $fd['primary_hashtag'] . '</a>
						</div>';
				
				// Retrieve a list of hashtags for this article
				if($hashtags = explode(" ", $fd['hashtags']) and $hashtags != array($fd['primary_hashtag']))
				{
					echo '
						<div class="c-elip"><a class="c-hlink" href="#">. . .</a></div>';
					
					foreach($hashtags as $tag)
					{
						if($tag == $fd['primary_hashtag']) { continue; }
						
						echo '
						<div class="c-htag-vis"><a class="c-hlink" href="' . $hashtagURL . '/' . $tag . '">#' . $tag . '</a></div>';
					}
				}
				
				echo '
					</div>';
			}
			
			echo '
				</div>
			</div>';
			
			// If there is no content tracking being displayed, end this loop
			if($doTracking)
			{
				// Prepare Values
				$boostClicked = "";
				$noochClicked = "";
				$jsAgg = "";
				
				// Make sure the user tracking values are at least available
				if(!isset($fd['user_vote']))
				{
					$fd['user_vote'] = 0;
					$fd['user_nooch'] = 0;
					$fd['user_shared'] = 0;
				}
				
				// Display the Content Tracking Data
				if($aggregate)
				{
					$fd['tips'] = "?";
					$fd['votes_up'] = "?";
					$fd['nooch'] = "?";
					$jsAgg = ', 1';
				}
				else if(is_int($fd['views']))
				{
					$fd['tips'] = round($fd['tipped_amount'] * 10);
					$boostClicked = $fd['user_vote'] == 1 ? "-track" : "";
					$noochClicked = $fd['user_nooch'] >= 3 ? "-track" : "";
				}
				else
				{
					$fd['votes_up'] = 0;
					$fd['nooch'] = 0;
					$fd['tips'] = 0;
				}
				
				echo '
				<hr class="c-hr-dotted" />
				<div class="c-options">
					<ul class="c-opt-list">
						<li id="boost-count-' . $contentID . '" class="c-bubble bub-boost">' . $fd['votes_up'] . '</li>
						<li id="boost-track-' . $contentID . '" class="c-boost' . $boostClicked . '"><a href="javascript:track_boost(' . $contentID . $jsAgg . ');"><span class="c-opt-icon icon-rocket"></span><span class="c-desktop"> &nbsp;Boost</span></a></li>
						
						<li id="nooch-count-' . $contentID . '" class="c-bubble bub-nooch">' . $fd['nooch'] . '</li>
						<li id="nooch-track-' . $contentID . '" class="c-nooch' . $noochClicked . '"><a href="javascript:track_nooch(' . $contentID . $jsAgg . ');"><span class="c-opt-icon icon-nooch"></span><span class="c-desktop"> &nbsp;Nooch</span></a></li>
						
						<li id="tip-count-' . $contentID . '" class="c-bubble bub-tip">' . $fd['tips'] . '</li>
						<li id="tip-track-' . $contentID . '" class="c-tip"><a href="javascript:track_tip(' . $contentID . $jsAgg . ');"><span class="c-opt-icon icon-coin"></span><span class="c-desktop"> &nbsp;Tip</span></a></li>
					</ul>
				</div>';
			}
		}
	}
	
}