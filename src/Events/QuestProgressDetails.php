<?php
namespace Bomb\Gamify\Events;


/**
 * Class QuestProgressDetails
 * @package Bomb\Gamify\Events
 * @desc Wrapper class for details passed to a quest progress event
 */
class QuestProgressDetails
{
    protected $progressIncrement; //how much should the event progress increase by
    protected $progressIdentifier; //a specific offer wall, feature or unique identifier to record
    protected $progressValue; //value of the recorded progress event, such as Coin balance, item number etc.
    protected $questEventAction; //the name of the action that has been triggered
    protected $progressModel; //a model representing the action that occurred
    protected $progressModelType; //the type of model passed in so we can infer details about it

    public function __construct(
                                $questEventAction,
                                $progressIncrement = 1,
                                $progressIdentifier = "",
                                $progressValue = "",
                                $progressModel = null,
                                $progressModelType = ""
    )
    {
        $this->progressIncrement = $progressIncrement;
        $this->questEventAction = $questEventAction;
        $this->progressIdentifier = $progressIdentifier;
        $this->progressValue = $progressValue;
        $this->progressModel = $progressModel;
        $this->progressModelType = $progressModelType;
    }


    /**
     * @return mixed
     */
    public function getProgressIncrement()
    {
        return $this->progressIncrement;
    }

    /**
     * @param mixed $progressIncrement
     */
    public function setProgressIncrement($progressIncrement)
    {
        $this->progressIncrement = $progressIncrement;
    }

    /**
     * @return mixed
     */
    public function getProgressIdentifier()
    {
        return $this->progressIdentifier;
    }

    /**
     * @param mixed $progressIdentifier
     */
    public function setProgressIdentifier($progressIdentifier)
    {
        $this->progressIdentifier = $progressIdentifier;
    }

    /**
     * @return mixed
     */
    public function getProgressValue()
    {
        return $this->progressValue;
    }

    /**
     * @param mixed $progressValue
     */
    public function setProgressValue($progressValue)
    {
        $this->progressValue = $progressValue;
    }

    /**
     * @return mixed
     */
    public function getQuestEventAction()
    {
        return $this->questEventAction;
    }

    /**
     * @param mixed $questEventAction
     */
    public function setQuestEventAction($questEventAction)
    {
        $this->questEventAction = $questEventAction;
    }

    /**
     * @return mixed
     */
    public function getProgressModel()
    {
        return $this->progressModel;
    }

    /**
     * @param mixed $progressModel
     */
    public function setProgressModel($progressModel)
    {
        $this->progressModel = $progressModel;
    }

    /**
     * @return mixed
     */
    public function getProgressModelType()
    {
        return $this->progressModelType;
    }

    /**
     * @param mixed $progressModelType
     */
    public function setProgressModelType($progressModelType)
    {
        $this->progressModelType = $progressModelType;
    }

}