<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contact extends Controller_Layout {
	
	public function action_index()
	{
		if ($_POST AND empty($_POST['extra']))
		{
			$this->view->bind('message', $message);
			
			$post = Validation::factory($_POST)
			                  ->rule('name', 'not_empty')
			                  ->rule('email', 'not_empty')
			                  ->rule('email', 'email')
			                  ->rule('phone', 'phone')
			                  ->rule('message', 'not_empty');
			                  
			if ($post->check())
			{
				$to = (Kohana::$environment === Kohana::DEVELOPMENT) ? 'rolo@ms2.ca' : 'melissa@ms2.ca';
				$from = $post['email'];
				$subject = 'Quote request via ms2.ca';
				
				$message_body = $post['name'].' has requested a quote: '."\n\n";
				$message_body .= $post['message']."\n\n";
				$message_body .= 'Callback number: '.$post['phone']."\n";
				$message_body .= 'Email address: '.$post['email'];
				
				try
				{
					Email::send($to, $from, $subject, $message_body);
					
					$message = 'Thank you for your email!';
				}
				catch (Exception $e)
				{
					$message = 'There was an error sending the email, please try again.';
					//echo Debug::vars($e);
				}
			}
			else
			{
				$message = 'Please check your form and retry';
			}
			
			$this->view->show_message = TRUE;
		}
	}
}