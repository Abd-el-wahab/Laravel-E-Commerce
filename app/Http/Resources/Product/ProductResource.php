<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'name' => $this->name,
        'description' =>$this->detail,
        'price' =>$this->price,
        'stock' =>$this->stock == 0 ? 'Out of stock' : $this->stock,
        'discount' =>$this->discount,
        'totalPrice' =>round( ( 1 - ($this->discount/100))* $this->price , 1 ),
        'rating' => $this->reviews->count() > 0 ? round($this->reviews->sum('star')/$this->reviews->count(),1) : 'This Product Has No rating',  // 3amlt el Round function 3ashan badl masln ma 2.333333333 tab2a 2 , we 3amlt if condutin en law el producty da ma3ndosh revviews yab3t mess 3ashan ma3mlsh error
        'href' => [
            'reviews' => route('reviews.index', $this->id)
        ]
        
        ];
    }
}
