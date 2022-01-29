<p align="center"><a href="https://iphonephotographyschool.com/" target="_blank"><img src="https://iphonephotographyschool.com/wp-content/themes/ips-theme/images/landing/ips-logo-footer.svg" width="400"></a></p>

## About Code
An Implementaion of an achievement and badge feature.

## Fire events
To fire events directly go to url  /fire-events

## Creating Achievements
Put your Achievement class In Preferred place and make sure your class extends Achievements class that stored in app/contracts/Achievements.

and you need to define some attributes and event trigger method. like
`$model` that contain achievements table
`$modelProgress` that contain achievement progress table
`triggerUnlocked($achiever)` to set event you want to fire when achievemnt unlocked
Like 

```php
class FirstCommentWritten extends Achievements
{
    public $model = Achievement::class;

    public $modelProgress = AchievementProgress::class;

    public $type = Achievement::TYPE_COMMENT_WRITTEN;
    
    /**
     * name
     *
     * @var string
     */
    public $name = "First Comment Written";
    
    /**
     * description
     *
     * @var string
     */

    public $description = "Achievement 1 Comment Written";

    public function triggerUnlocked($achiever)
    {
        event(new AchievementUnlocked($this->name, $achiever));
    }

}
```


## Unlocking Achievements
Achievements can be unlocked via using the `Achiever` trait who placed in `App\Traits`. 
use it in user model and you can use function unlock.

```php
$user->unlock($achivement);
```

## Adding Achievements Progress
The sam unlock you have anthoer two functions
addProgress to add points progress to user achievement.

```php
$user->addProgress($achivement, $points);
```

And setProgress to adding progress points to user achievement.

```php
$user->setProgress($achivement, $points);
```


## Group Of Achievemnts.
I created a class AchievementsGroup that handle a group of related achievemtns. via adding array of achievemnts in group method.
And run addGroupProgress function to go through the array of acheivemnet and unlock or set progress. like

```php
class CommentsAchievementsGroup extends AchievementsGroup
{

    /**
     * Array of achivements.
     *
     * @return array
     */
    public function group()
    {
        return [
            new FirstCommentWritten(),
            new ThreeCommentsWritten(),
            new FiveCommentsWritten(),
            new TenCommentsWritten(),
            new TwentyCommentsWritten(),
        ];
    }
}

(new CommentsAchievementsGroup)->addGroupProgress($user, $countUserComments);
```


