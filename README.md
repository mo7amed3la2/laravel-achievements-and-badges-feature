<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About Code
An Implementaion of an achievement and badge feature.

## Fire events
To fire events directly go to url  /fire-events

## Creating Achievements
Put your Achievement class In Preferred place and make sure your class extends Achievements class that stored in app/contracts/Achievements.

and you need to define some attributes and event trigger method. like
`$model` that contain achievements table
`$modelProgress` that contain achievement progress table
`triggerUnlocked` to set event you want to fire when achievemnt unlocked
Like 

```php
$model = Achievement::class;

$modelProgress = AchievementProgress::class;

$type = Achievement::TYPE_COMMENT_WRITTEN;

public function triggerUnlocked($achiever)
{
    event(new AchievementUnlocked($this->name, $achiever));
}
```


## Unlocking Achievements
Achievements can be unlocked by using the Achiever trait.
use it in user model and you can use functions unlock.

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


