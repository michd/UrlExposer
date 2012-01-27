<?php
/**
 * Main class for the application.
 * 
 * Since it's a very simple thing with just one function, everything can fit 
 * into a single class really.
 * 
 * If later on it extends in a certain way, it can be split up.
 */
class UrlExposer 
{
	/**
	 * The maximum amount of redirects to follow before giving up.
	 */
	const MAX_REDIRECTS = 10;
	
	/**
	 * The initial url given
	 * 
	 * @var string 
	 */
	protected $input_url = '';
	
	/**
	 * The result figured out at the end
	 * 
	 * @var string
	 */
	protected $result_url = '';
	
	/**
	 * Amount of redirects followed to get to result_url
	 * 
	 * @var int 
	 */	
	protected $redirect_count = 0;
	
	/**
	 * Array of all the steps taken by following the URLs. 
	 * 
	 * Format:
	 * array(
	 *		[0] => array(
	 *				'http_status' => <int>,
	 *				'url' => <string>
	 *		),
	 *		...
	 * )
	 * 
	 * 
	 * @var array 
	 */
	public $steps = array();
	
	
	/**
	 * Starts all the fun things!
	 * 
	 * @param string $start_url 
	 */
	public function __construct($start_url)
	{
		$this->input_url = $start_url;
		$this->_step_through($start_url);		
	}
	
	/**
	 * Retrieves a variable
	 * 
	 * Using a getter because we don't want the inner variables being SET by
	 * anything other than this class.
	 * 
	 * @param string $name
	 * @return mixed 
	 */
	public function __get($name)
	{
		switch (strtolower($name))
		{
			case 'result_url':
			case 'result': return $this->result_url;
			case 'input_url':
			case 'input': return $this->input_url;
			case 'step_count': return $this->redirect_count;
			case 'steps': return $this->steps;
			default: return null;
		}
	}
	
	
	/**
	 * Steps through the given URL, doing the following:
	 * 
	 * Gets headers and figures out whether it is a redirect or not
	 * If it is a redirect, recursion occurs, as the function invokes itself.
	 * If no more redirection is detected, or MAX_REDIRECTS has been reached,
	 * the function stops and returns the found URL.
	 * 
	 * Through this process the steps as saved in $this->steps. 
	 * 
	 * If anything goes wrong, bool(false) is returned.
	 *
	 * @param string $input_url
	 * @return string or bool(false) 
	 */
	protected function _step_through($input_url) 
	{
		if ($this->redirect_count < self::MAX_REDIRECTS)
		{
			$headers = get_headers($input_url, 1);
			if($headers !== false)
			{				
				$step = array(); //where we will save the info of this step
				
				$status = $headers[0];
				$status_split = explode(' ', $status);
				$status_code = isset($status_split[1]) ? $status_split[1] : false;
				if ($status_code)					
				{
					$step['status'] = $status_code;
					
					if (isset($headers['Location']))
					{ //It's probably a redirect if this is set
						$step['url'] = is_array($headers['Location']) ? $headers['Location'][0] : $headers['Location'];
						$this->steps[] = $step;
						$this->redirect_count += 1;
						return $this->_step_through($step['url']);
					}
					else
					{
						//THE END
						$step['url'] = $input_url;
						$this->steps[] = $step;
						$this->result_url = $step['url'];
						return $this->result_url;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
	}
}