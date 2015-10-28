<?php
// src/v1m/TaskBundle/Entity/Task.php
namespace v1m\TaskBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="task", type="string", length=255)
     */
    protected $task;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     */
    protected $email;

    /**
     * @var date
     *
     * @ORM\Column(name="duedate", type="date")
     */
    protected $dueDate;

    public function getId()
    {
        return $this->id;
    }
    public function getTask()
    {
        return $this->task;
    }
    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }
    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }
}