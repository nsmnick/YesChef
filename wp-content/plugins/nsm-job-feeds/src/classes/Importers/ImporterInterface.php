<?php
namespace nsm\nsmJobsFeed\Importers;

interface ImporterInterface
{
	public function import();
	public function clearFeedPosts($feed_name);
	public function createPosts($job_postings);
}
