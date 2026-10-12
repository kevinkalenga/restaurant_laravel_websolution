
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuGallery extends Model
{
    protected $table = 'menu_galleries';

    protected $fillable = [
        'menu_id',
        'image',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
