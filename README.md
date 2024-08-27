# How to use it
first add this to your composer.json
```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:username/repository-name.git" // or using https
    }
],
```
then run this command
```
composer require ta3leem/photo-column
```
then add the following code in your resource list file (ex: ListUsers.php)
```

<?php

use Livewire\WithFileUploads;

class ListUsers extends ListRecords
{
    use WithFileUploads;

    public $photo;

    public function updatePhoto($name, $recordKey)
    {
        // delete the old photo
        $oldPhoto = YourModel::query()->where('id', (int) $recordKey)->value($name);
        Storage::delete("updatedPhotos/{$oldPhoto}");

        // generate hash name for the photo
        $photoName = Str::uuid7().'.jpeg';

        // store the photo in the public photo directory
        $this->photo->storeAs('./', $photoName);

        // update the photo name in the database
        YourModel::query()->where('id', (int) $recordKey)->update([
            $name => $photoName,
        ]);
    }
}
```
the updatePhoto function will handel the upload functionality (just like in normal livewire component)

You must publish the config file 
```
php artisan vendor:publish --tag=photo-column-config
```
then specifiy in config the default image to use if something goes wrong. the path begin from the public directory so you don't need to add it.
