<?php
namespace nsm\nsmJobsFeed\Importers;

use nsm\nsmJobsFeed\Importers\ImporterInterface;

class docuwareJobsImporter implements ImporterInterface
{

	public $feed_name = 'Docuware Jobs';
	
	// Test
	//public $feed_url = 'https://bnpparibas-config.tal.net/vx/mobile-0/brand-2/candidate/jobboard/vacancy/1/feed/structured';
	// Live
	public $feed_url = 'https://amberstonedocuwarewebservice.azurewebsites.net/website.xml';



	// These are set in the main project custom fields section

	protected $post_type = 'nsm_job_post';
	
	protected $taxonomies = [
		'nsm_job_locations'
		,'nsm_job_functions'
	];


	public function import()
	{


		$xml = $this->getXml();

		if ($xml !== false) {
			$parsed_xml = $this->parseXml($xml);

			if ($parsed_xml !== false) {
				$this->clearFeedPosts($this->feed_name);

				return $this->createPosts($this->normalizePostData($parsed_xml));
			} else {
				return 'Failed to parse XML!';
			}

		} else {
			return 'Failed to create Jobs!';
		}

		return true;
	}

	public function clearFeedPosts($feed_name)
	{
		global $wpdb;
		// Find all posts that came from this feed and delete them.
		$wpdb->query(
			$wpdb->prepare("
					DELETE a, b, c
					 FROM $wpdb->posts a
					 LEFT JOIN $wpdb->term_relationships b
						 ON (a.ID = b.object_id)
					 LEFT JOIN $wpdb->postmeta c
						 ON (a.ID = c.post_id)
					 WHERE a.post_type = %s
				"
				, $this->post_type
			)
		);

		// Update taxonomy counts
		foreach ($this->taxonomies as $taxonomy) {
			$taxonomy_terms = get_terms([
				'taxonomy' => $taxonomy
				, 'fields' => 'ids'
				, 'hide_empty' => false
			]);

			if (!is_wp_error( $taxonomy_terms ) && !empty( $taxonomy_terms )) {
				wp_update_term_count_now($taxonomy_terms, $taxonomy);
			}
		}
	}

	private function parseXml($xml)
	{
		return simplexml_load_string($xml);
	}


	private function getXml()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $this->feed_url);
		$data = curl_exec($ch);

		if (curl_error($ch)) {
			curl_close($ch);
			return false;
		}
		curl_close($ch);
		return $data;
	}


	public function createPosts($job_postings)
	{
		$status = [
			'Added' => 0
			, 'Failed' => []
		];

		if (!empty($job_postings)) {

			foreach ($job_postings as $job) {

				//echo '<pre>'.print_r($job, true).'</pre>';

				$job_post_data = [
					'post_title' => $job['title']
					, 'post_content' => $job['description']
					, 'post_status' => 'publish'
					, 'post_type' => $this->post_type
				];

				$post_id = wp_insert_post($job_post_data);

				if ($post_id) {
					update_post_meta($post_id, 'feed_name', $this->feed_name);
					update_post_meta($post_id, 'job_ref', $job['job_ref']);
					update_post_meta($post_id, 'location', $job['location']);
					update_post_meta($post_id, 'function', $job['function']);
					update_post_meta($post_id, 'date_posted', $job['date_posted']);
					update_post_meta($post_id, 'education', $job['education']);     
					update_post_meta($post_id, 'experience', $job['experience']); 
					update_post_meta($post_id, 'questions', $job['additional_questions']);       


					// Add locations
					if (!empty($job['location'])) {
						$location_term = $this->createTerm(
							$post_id
							, $job['location']
							, 'nsm_job_locations'
							, $status
						);
					}


					if (!empty($job['function'])) {
						$programme_type_term = $this->createTerm(
							$post_id
							, $job['function']
							, 'nsm_job_functions'
							, $status
						);
					}


					if ( function_exists( 'add_application_form_question_fields' ) ) {
        				add_application_form_question_fields($job['additional_questions']);
    				}
    
					

 						




					$status['Added'] = $status['Added'] + 1;
				} else {
					$status['Failed'][] = $job;
				}

			}
		}
		return $status;
	}


	public function createTerm($post_id, $term_text, $taxonomy, &$status, $parent = 0)
	{
		if ($term_text != '') {
			$term = term_exists($term_text, $taxonomy);

			if (!$term) {
				$term = wp_insert_term($term_text, $taxonomy, ['parent' => $parent]);
			}

			if (!is_wp_error($term)) {
				wp_set_object_terms($post_id, (int)$term['term_id'], $taxonomy, true);
			} else {
				$status['Term add failed'][] = 'Post ID: '.$post_id.' Term_text: '.$term_text;
				return false;
			}
			return $term;
		}
	}


	private function normalizePostData(&$job_ads)
	{
		$job_postings = [];

		foreach ($job_ads->job as $job) {


			// echo print_r($job);
			// echo '<br/><br/><br/>';

			// echo 'JOB<br/>';
			// echo (string) $job->title . '<br/>';
			// echo (string) $this->normalizeDate($job->date) . '<br/>';
			// echo (string) $job->category . '<br/>';
			// echo (string) $job->city . '<br/>';

			// echo '<br/><br/><br/>';
			

			$description = $this->cleanHTML($job->description);
			$description .= '<h4>Education</h4>';
			$description .= $this->cleanHTML($job->education);
			$description .= '<h4>Experience</h4>';
			$description .= $this->cleanHTML($job->experience);

			$additional_questions = array();

			echo 'questions';
			echo '<br>';
			foreach ($job->additionalquestion as $additional_question) {
				

				

//				echo $additional_question->question;
//				echo '<br>';

				$answers = array();
				foreach ($additional_question->answer as $answer) {

					$answers[] = (string) $answer;
					//echo $answer;
//					echo '<br>';

				}

				$question = array('question' => (string) $additional_question->question, 'answers' => $answers);
				$additional_questions[] = $question;

			}
			

			


			// echo print_r($additional_questions);
			// die();



			$job_postings[] = [
				//'job_id' => $job_id    
				
				'title' => 			(string) $job->title
				, 'description' => 	(string) $description
				, 'job_ref' => 		(string) $job->referencenumber
				, 'location' => 	(string) $job->region
				, 'function' => 	(string) $job->category
				, 'education' => 	(string)$job->education
				, 'experience' => 	(string)$job->experience
				, 'date_posted' => 	(string) $this->normalizeDate($job->published_date)
				, 'additional_questions' => serialize($additional_questions)
			];

		}

		return $job_postings;
	}

	private function normalizePostContentData($content,$field,$endmarker='</span>',$endmarkerbackchars=0)
	{
		// Field Field in content string

		$start = strpos($content , "=\"".$field."\"");

		if($start)
		{
			$start = $start+strlen($field)+4;
			$end = strpos($content , $endmarker, $start) - $endmarkerbackchars;
		}

		// echo $content . '<br/>';
		// echo 'start'. $start . '<br/>';
		// echo 'end'. $end . '<br/>';

		if($start && $end) {
			return substr($content, $start, ($end-$start));
		} else {
			return '';
		}

	}


	private function normalizeDate($date_string)
	{
		return date('Y-m-d H:i:s', strtotime($date_string));
	}


	private function cleanHtml($html = '')
	{
		$config = \HTMLPurifier_Config::createDefault();
		$config->set('CSS.AllowedProperties', array());
		$config->set('AutoFormat.RemoveEmpty', true);
		$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		$config->set('HTML.AllowedElements', array(
			'p'
			, 'div'
			, 'a'
			, 'table'
			, 'thead'
			, 'tbody'
			, 'tr'
			, 'th'
			, 'td'
			, 'ul'
			, 'ol'
			, 'li'
			, 'b'
			, 'strong'
			, 'i'
			, 'em'
			, 'h1'
			, 'h2'
			, 'h3'
			, 'h4'
			, 'h5'
			, 'h6'
		));
		$config->set('HTML.AllowedAttributes', array(
			'a.href'
		));
		$config->set('HTML.TargetBlank', true);

		$def = $config->getHTMLDefinition(true);
		$def->info_tag_transform['b'] = new \HTMLPurifier_TagTransform_Simple('strong');
		$def->info_tag_transform['i'] = new \HTMLPurifier_TagTransform_Simple('em');
		$def->info_tag_transform['div'] = new \HTMLPurifier_TagTransform_Simple('p');

		$purifier = new \HTMLPurifier($config);
		return preg_replace('/\s+/', ' ', trim($purifier->purify($html)));
	}

}
