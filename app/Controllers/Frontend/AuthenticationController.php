<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Frontend\AuthUsers;

class AuthenticationController extends BaseController
{
	public function index()
	{
		//
		return view('frontend/index');
	}

	public function login()
	{

		return view('frontend/login');
	}
	public function forgetPassword()
	{

		return view('frontend/forget-password');
	}

	// public function store()
	// {

	// 	helper('form', 'url');

	// 	$rules = [
	// 		'name' => 'required',
	// 		'email' => 'required|is_unique[users.email]',
	// 		'password' => 'required|min_length[5]',
	// 	];

	// 	if($this->validate($rules)){

	// 		$AuthUsers = new AuthUsers();

	// 		$data = [
	// 			'name' => $this->request->getPost('name'),
	// 			'email' => $this->request->getPost('email'),
	// 			'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT)
	// 		];

	// 		$AuthUsers->insert($data);

	// 		return redirect()->to('login')->with('success', 'Registration successful. Please login!');

	// 	}else{

	// 		return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

	// 	}

	// }


	// public function store()
	// {

	// 	helper('form', 'url');

	// 	$rules = [
	// 		'name' => [
	// 			'rules' => 'required',
	// 			'errors' => [
	// 				'required' => 'Please enter your name',
	// 			],
	// 		],
	// 		'email' => [
	// 			'rules' => 'required|is_unique[users.email]|valid_email',
	// 			'errors' => [
	// 				'required' => 'Please enter your email',
	// 				'is_unique' => 'The email is already registered.',
	// 				'valid_email' => 'Please enter a valid email'
	// 			],
	// 		],
	// 		'password' => [
	// 			'rules' => 'required|min_length[6]',
	// 			'errors' => [
	// 				'required' => 'Please enter your password',
	// 				'min_length' => 'password must be al least 6 character long',
	// 			],
	// 		],
	// 	];

	// 	if ($this->validate($rules)) {
	// 		$userModel = new AuthUsers();

	// 		$data = [
	// 			'name' => $this->request->getPost('name'),
	// 			'email' => $this->request->getpost('email'),
	// 			'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT)
	// 		];

	// 			$userModel->insert($data);

	// 		return redirect()->to(base_url('login'))->with('success', 'Register succesfull!');
	// 	} else {
	// 		return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
	// 	}
	// }


	public function store()
{
    helper('form', 'url');

    $rules = [
        'name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Please enter your name',
            ],
        ],
        'email' => [
            'rules' => 'required|is_unique[users.email]|valid_email',
            'errors' => [
                'required' => 'Please enter your email',
                'is_unique' => 'E-mail already registered',
                'valid_email' => 'Invalid email'
            ],
        ],
        'password' => [
            'rules' => 'required|min_length[6]',
            'errors' => [
                'required' => 'Please enter your password',
                'min_length' => 'At least 6 characters'
            ],
        ],
    ];

    if ($this->validate($rules)) {
        $userModel = new AuthUsers();
        
        // Get user information
        $ipAddress = $this->request->getIPAddress();
        $userAgent = $this->request->getUserAgent();

        $device = $userAgent->getPlatform(); // OS (Windows, Linux, Android, etc.)
        $browser = $userAgent->getBrowser(); // Browser (Chrome, Firefox, etc.)
        $isMobile = $userAgent->isMobile() ? 'Mobile' : 'Desktop';

        // Handle location for loopback IPs
        if ($ipAddress === '::1' || $ipAddress === '127.0.0.1') {
            $locationData = [
                'location' => 'Localhost',
                'full_data' => [
                    'status' => 'success',
                    'message' => 'Loopback IP address',
                    'query' => $ipAddress
                ]
            ];
        } else {
            $locationData = $this->getLocation($ipAddress);
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'ip_address' => $ipAddress,
            'device' => $device,
            'browser' => $browser,
            'device_type' => $isMobile,
            'location' => $locationData['location'],
        ];

        $userModel->insert($data);

        return $this->response->setJSON([
            'success' => true,
            'debug_info' => [
                'ip_address' => $ipAddress,
                'location_data' => $locationData,
                'device' => $device,
                'browser' => $browser,
                'device_type' => $isMobile
            ]
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'errors' => $this->validator->getErrors(),
        ]);
    }
}

private function getLocation($ip)
{
    $url = "http://ip-api.com/json/" . $ip;
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    if ($data['status'] == 'success') {
        return [
            'location' => $data['city'] . ', ' . $data['country'],
            'full_data' => $data // Return full API response for debugging
        ];
    }

    return [
        'location' => 'Unknown Location',
        'full_data' => $data // Return API response even if failed
    ];
}


	public function doLogin()
	{
		$rules = [
			'email' => [
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'Please enter your email',
					'valid_email' => 'invalid email'
				],
			],
			'password' => [
				'rules' => 'required',
				'errors' => [
					'required' => 'Please enter your password',
				],
			],

		];
		if ($this->validate($rules)) {
			$userModel = new AuthUsers();

			$email = $this->request->getPost('email');
			$password = $this->request->getPost('password');

			$user = $userModel->where('email', $email)->first();

			if ($user && password_verify($password, $user['password'])) {

				session()->set([
					'user_id' => $user['id'],
					'is_logged' => true,
				]);

				if ('rememberMe') {
					$remember = service('response');
					$remember->setcookie('remember_email', $email, 2592000);
					$remember->setcookie('remember_password', $password, 2592000);
				}

				return $this->response->setJSON([
					'success' => true,
					'message' => 'Login successful!',
				]);
			}
			return $this->response->setJSON([
				'success' => false,
				'messages' => 'invalid email or password',
			]);
		}
		return $this->response->setJSON([
			'success' => false,
			'errors' => $this->validator->getErrors(),
		]);
	}

































	public function doForgetPassword()
	{

		helper(['text', 'form', 'url']);

		$rules = [

			'email' => [
				'rules' => 'required|valid_email',
				'errors' => [
					'required' => 'Please enter your email',
					'valid_email' => 'Please enter a valid email',
				],
			],

		];

		if ($this->validate($rules)) {

			$email = $this->request->getPost('email');

			$userModel = new AuthUsers();

			$user = $userModel->where('email', $email)->first();

			if (!$user) {

				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Email not found'
				]);
			}

			$resetCode = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
			$expiry = date('Y-m-d, H:i:s', strtotime('+5 minutes'));

			$userModel->update($user['id'], [
				'forget_pass' => $resetCode,
				'expiry' => $expiry,
			]);

			$emailService = \Config\Services::email();
			$emailService->setTo($email);
			$emailService->setFrom(getenv('email.fromEmail'), getenv('email.fromName'));
			$emailService->setSubject('Forget password');

			$content = view('emails/forget-password', ['name' => $user['name'], 'code' => $resetCode]);
			$emailService->setMessage($content);


			if ($emailService->send()) {
				return $this->response->setJSON([
					'status' => 'success',
					'message' => 'Reset code generated! - Reset email sent',
					'forget_pass' => $resetCode,
					'expiry' => $expiry,
				]);
			}

			return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to send email']);
		}
	}
}
