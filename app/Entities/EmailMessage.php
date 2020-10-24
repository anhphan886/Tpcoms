<?php
namespace App\Entities;

/**
 * Class BroadcastMessage
 * @package App\Models
 * @author DaiDP
 * @since Sep, 2019
 */
class EmailMessage extends JobMessageEntity
{
    public $object_id;

    public $template_name;

    public $email_type;

    public $email_subject;

    public $email_to;

    public $email_from;

    public $email_from_name;

    public $email_cc;

    public $email_body;

    public $email_params;

    public $email_attach;

    /**
     * BroadcastMessage constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->build();

    }

    public function build(){
        switch ($this->email_type){
            case 'order';
                $view = 'email.order.success';
            default:
                $view = 'email.order.success';
        }

        $this->email_params = json_decode($this->email_params, true);

        $this->email_body = view($view, $this->email_params)->render();

    }
}
