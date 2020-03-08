<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Episodio extends Model {

    public $timestamps = false;
    protected $fillable = ['temporada', 'numero', 'assistido', 'serie_id'];
    protected $appends = ["links"];

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }

    public function getAssistidoAttribute($assisitdo): bool
    {
        return $assisitdo;
    }

    public function getLinksAttribute($links)
    {
        return [
            "self" => "/api/series/" . $this->serie_id . "/episodios\/" . $this->id,
            "episodios" => "/api/series/" . $this->serie_id
        ];
    }

}