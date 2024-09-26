<?php
namespace App\Controller;

use App\Form\EmailForm;
use App\Form\ForgotPasswordForm;
use App\Form\ResetPasswordForm;
use App\Model\Entity\User;
use Cake\Mailer\MailerAwareTrait;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    use MailerAwareTrait;

    /**
     * Initialize method
     *
     * @return void
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(
            [
                'registerMember',
                'verifyMemberAccount',
                'logout',
                'forgotPassword',
                'resetPassword',
            ]
        );
    }

    /**
     * isAuthorized method
     *
     * @param array|null $user The currently logged-in user's data.
     * @return bool True if the user is authorized, false otherwise.
     */
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        $requestedUserId = (int)$this->request->getParam('pass.0');

        // Admins access
        if (User::isAdmin($user['role'])) {
            return true;
        }

        // Assistants access
        if (User::isAssistant($user['role'])) {
            if (in_array($action, ['view', 'edit', 'delete'])) {
                $requestedUser = $this->Users->get($requestedUserId);
                if (
                    ($requestedUserId === $user['id'] && $action !== 'delete') ||
                    ($action !== 'delete' && User::isPublisher($requestedUser->role))
                ) {
                    return true;
                }

                if ($action === 'delete' && User::isPublisher($requestedUser->role)) {
                    return true;
                }

                return false;
            }

            return true;
        }

        // Publishers and member access
        if (User::isPublisher($user['role']) || User::isMember($user['role'])) {
            if (in_array($action, ['view', 'edit', 'updatePassword']) && $requestedUserId === $user['id']) {
                return true;
            }

            if ($action === 'index') {
                return true;
            }

            return false;
        }

        // Default deny
        return false;
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|void|null
     */
    public function login()
    {
        if ($this->Auth->user()) {
            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                if ($user['status']) {
                    $this->Auth->setUser($user);

                    return $this->redirect($this->Auth->redirectUrl());
                }

                $this->Flash->error(__('Your account is restricted from using the system.'));
            } else {
                $this->Flash->error(__('Your username or password is incorrect.'));
            }
        }
    }

    /**
     * Logout method
     *
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        $this->Flash->success(__('You are now logged out.'));

        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $sessionUser = $this->Auth->user();
        $query = $this->Users->find('byRole', ['user' => $sessionUser]);
        $users = $this->paginate($query);
        $this->set(compact('sessionUser', 'users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id
     * @return void
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|void|null
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        $sessionUser = $this->Auth->user();
        $sessionUserRole = $sessionUser['role'];
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if (!User::isAdmin($sessionUserRole)) {
                $data['status'] = User::STATUS_ACTIVE;
            }
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user', 'sessionUser'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id
     * @return \Cake\Http\Response|void|null
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        $sessionUser = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user', 'sessionUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Mail method
     *
     * @param string|null $id Publisher's ID
     * @return \Cake\Http\Response|void|null
     */
    public function mail($id = null)
    {
        $emailForm = new EmailForm();
        $user = $this->Users->get($id);

        // Check user before proceeding to mailing
        if (!$user->status || !User::isPublisher($user->role)) {
            $this->Flash->error(__('The user is either not a publisher or is restricted.'));

            return $this->redirect(['action' => 'index']);
        }

        // Send email
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user'] = $user;

            if ($emailForm->execute($data)) {
                $this->Flash->success(__('Email has been sent to {0}.', $user->name));

                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('user', 'emailForm'));
    }

    /**
     * forgotPassword method.
     *
     * @return \Cake\Http\Response|void|null
     *
     */
    public function forgotPassword()
    {
        $forgotPasswordForm = new ForgotPasswordForm();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if ($forgotPasswordForm->execute($data)) {
                $this->Flash->success(__('Password reset email sent. Please check your inbox.'));

                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error(__('No user found with that email address.'));
        }
        $this->set(compact('forgotPasswordForm'));
    }

    /**
     * resetPassword method.
     *
     * @param string $token Token
     * @return \Cake\Http\Response|void|null
     */
    public function resetPassword($token = null)
    {
        $resetPasswordForm = new ResetPasswordForm();

        if (!$token) {
            $this->Flash->error(__('Invalid token.'));

            return $this->redirect(['action' => 'login']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['token'] = $token;

            if ($resetPasswordForm->execute($data)) {
                $this->Flash->success($resetPasswordForm->message);

                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error($resetPasswordForm->message);
        }

        $this->set(compact('resetPasswordForm'));
    }

    /**
     * RegisterMember method for member users
     *
     * @return \Cake\Http\Response|void|null
     */
    public function registerMember()
    {
        if ($this->Auth->user()) {
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $data, ['validate' => 'memberRegistration']);
            if ($this->Users->save($user)) {
                $tokenData = $this->Users->getToken($user->email);
                if ($tokenData) {
                    $this->getMailer('User')->send('sendMemberVerificationEmail', [$user->email, $tokenData['token']]);
                }
                $this->Flash->success(__('Registration successful. Please check your email to verify your account.'));

                return $this->redirect(['action' => 'login']);
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Verify member account method for registration of member users
     *
     * @param string|null $token Token
     * @return \Cake\Http\Response|null
     */
    public function verifyMemberAccount($token = null)
    {
        /**
         * @var \App\Model\Entity\User $user
         */
        $user = $this->Users->find()
            ->where(['token' => $token])
            ->first();

        if (!$user || $user->token_expired_at->isPast()) {
            $this->Flash->error(__('Invalid or expired token.'));

            return $this->redirect(['action' => 'login']);
        }

        $user = $this->Users->patchEntity($user, [
            'status' => User::STATUS_ACTIVE,
            'token' => null,
            'token_expired_at' => null,
        ]);

        if ($this->Users->save($user)) {
            $this->Flash->success(__('Your account has been successfully verified. You can now log in.'));

            return $this->redirect(['action' => 'login']);
        }
        $this->Flash->error(__('Account verification failed. Please try again.'));

        return $this->redirect(['action' => 'login']);
    }

    /**
     * updatePassword method.
     *
     * @param string|null $id User id
     * @return \Cake\Http\Response|void|null
     */
    public function updatePassword($id = null)
    {
        if ($this->Auth->user('id') !== (int)$id) {
            $this->Flash->error(__('Invalid user.'));

            return $this->redirect(['action' => 'login']);
        }
        $user = $this->Users->get($id);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $data['user'] = $user;
            $user = $this->Users->patchEntity($user, $data, [
                'validate' => 'updatePassword',
            ]);

            if (!$user->getErrors()) {
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Your password has been updated.'));

                    return $this->redirect(['action' => 'view', $id]);
                }
                $this->Flash->error(__('There was an error updating your password. Please try again.'));
            }
        }
        $this->set(compact('user'));
    }
}
