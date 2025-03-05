<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*-----------------------------------------------------------------------------
	Author : Rahul D 							Date : 25-07-2018
-----------------------------------------------------------------------------*/
class Post_hook_controller extends REST_Controller {
	/*-----------------------------------------------------------------------------
		Author : Rahul D 							Date : 25-07-2018
	-----------------------------------------------------------------------------*/
	public function checkLogin() {
		$segment_arr = $this->uri->segment_array();
		$count=count($segment_arr);
		$segment_arr = array_map('strtolower', $segment_arr);
		// add url in lower case
		$exceptions=array(
					"check-login",
					"about-us",
					/* "addiction-prevention-programme",
					"volunteers", */
					"blogs",
					"contact-us",
					"home",
					"save-contact-us",
					/* "save-volunteer",
					"our-team", */
				
				/* 	"download-volunteer-pdf",
					"download-contact-us-excel",
					"download-volunteer-excel", */
					"logout",
					'terms-conditions',
					'privacy-policy',
					"newgetfilepathsite",
					/* "recruitment-login",
					"check-student-login",
					"recover-password",
					"recruitment-dashboard",
					"recruitment-logout", */
					"checkOldPassword",
					"reset-password",
					"changePassword",
					/* "create-account-list",
					"sustainable-cities",
					"good-health-well-being",
					"quality-education", */
				/* 	"corporate",
					"individuals", */
					"gallery",
					"contact-us",
					"contribute","terms"
					);
					if($count>0)
					{
						if(strtolower($segment_arr[1]) !='blogs'){
							$segment = $segment_arr[$count];
							if(!array_intersect($segment_arr, $exceptions )) {
								$this->load->module("user_mgmt/auth_api");
								$res = $this->auth_api->_isAccess();
								if(isset($res) && !$res["state"]) {
									$allowed_headers = implode(' ,', $this->config->item('allowed_cors_headers'));
									$allowed_methods = implode(' ,', $this->config->item('allowed_cors_methods'));
									// If we want to allow any domain to access the API
									if ($this->config->item('allow_any_cors_domain') === TRUE) {
										header('Access-Control-Allow-Origin: *');
										header('Access-Control-Allow-Headers: '.$allowed_headers);
										header('Access-Control-Allow-Methods: '.$allowed_methods);
									}
									else {
										// We're going to allow only certain domains access
										// Store the HTTP Origin header
										$origin = $this->input->server('HTTP_ORIGIN');
										if ($origin === NULL) {
											$origin = '';
										}
										// If the origin domain is in the allowed_cors_origins list, then add the Access Control headers
										if (in_array($origin, $this->config->item('allowed_cors_origins'))) {
											header('Access-Control-Allow-Origin: '.$origin);
											header('Access-Control-Allow-Headers: '.$allowed_headers);
											header('Access-Control-Allow-Methods: '.$allowed_methods);
											header('Access-Control-Allow-Credentials: true');
										}
									}
			
									// If the request HTTP method is 'OPTIONS', kill the response and send it to the client
									if ($this->input->method() === 'options') {
										exit;
									}
									$response = array("msg"=>"Session timeout, Please login and continue.", "state"=>FALSE);
									$this->response($response, REST_Controller::HTTP_UNAUTHORIZED);
								}
							}
						}
					}
	}
}