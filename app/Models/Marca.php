<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model {
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return [
            "nome" => "required|unique:marcas,nome,'.$this->id.'|min:3",
            "imagem" => "file|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatorio',
            'imagem.nines' => 'O arquivo deve ser um png, jpg ou jpng',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome da marca deve ter pelo menos 3 caracteres'
        ];
    }

    public function modelos() {
        return $this->hasMany('App\Models\Modelo');
    }
}
