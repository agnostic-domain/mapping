# General idea

Mapping API aims to achieve maximum simplicity without sacrificing agnosticy of domain.

## `adm` function

Global function `adm` accepts 3 types of arguments:
* `string` - this is the class string of an object that should be constructed and hydrated.
* `object` - this is the object from which data is extracted.
* `null` or preferably nothing - grants access to helper API.

## Constructing and hydrating object

If you called `adm` function with class string as an argument, then you should call methods with the same names as the properties in that class passing desired values as arguments.
At the end you should invoke the builder to build the object, optionally passing data object as argument to remember it for reverse mapping.

## Extracting data from object

If you called `adm` function with `object`, then you should call methods with the same names as the properties in that object. Values they return are the values of selected properties.
It is basically streamlined extraction by reflection.

## Helper API

If you called `adm` function without arguments, then you can call methods in the helper API:
* `data` - returns remembered data object for reverse mapping.
* `collection` - it compares data objects array with domain objects array by **key**. Then it exposes 3 additional methods:
  * `added` - expects closure which will be called with added domain objects.
  * `removed` - expects closure which will be called with removed domain objects.
  * `changed` - expects closure which will be called with domain objects that potentially changed.

## Example

```php
/**
 * Data class representing table in database
 */
final class User
{
    public string $id;
    public string $email;
    public string $groupId;
}

/**
 * Domain object representing a user
 */
final class User
{
    private Id $id;
    private Email $email;

    public function __construct(Email $email)
    {
        $this->id = new Id();
        $this->email = $email;
    }

    public function id(): Id
    {
        return $this->id;
    }
}

/**
 * Domain class representing a users' group
 */
final class Group
{
    private Id $id;
    private array $users = [];

    public function __construct()
    {
        $this->id = new Id();
    }

    public function add(User $user): void
    {
        $this->users[(string) $user->id()] = $user;
    }

    public function remove(Id $userId): void
    {
        unset($this->users[(string) $userId]);
    }
}

/**
 * Repository retrieving and persisting domain objects
 */
final class Repository
{
    public function get(Id $id): Group
    {
        $users = /* retrieve data users */

        return adm(Group::class)
            ->id(adm(Id::class)->value(reset($users)->groupId)())
            ->users(array_map(fn($user) => $this->user($user), $users))($users);
    }

    private function user(Data\User $user): Domain\User
    {
        return adm(Domain\User::class)
            ->id(adm(Id::class)->value($user->id)())
            ->email(adm(Email::class)->value($user->email)())();
    }

    public function add(Group $group): void
    {
        adm()->collection(adm()->data($group), adm($group)->users())
            ->removed(function($user) { /* remove data user */ })
            ->added(function($user) { /* persist data user */ })
            ->changed(function(Data\User $dataUser, Domain\User $domainUser) {
                $dataUser->id = adm(adm($domainUser)->id())->value();
                $dataUser->email = adm(adm($domainUser)->email())->value();
                /* persist data user */
            });
    }
}
```

You can also check [example use case](../use-case).
