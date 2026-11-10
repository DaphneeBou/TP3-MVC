<?php
namespace App\Models;

class Journal extends CRUD {
    protected $table = 'journal';
    protected $primaryKey = 'id';
    protected $fillable = ['ip', 'username', 'page'];
}
