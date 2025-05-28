<?php

namespace App\helper\Cart;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;
    public function __construct()
    {
        $this->cart = session()->get('cart') ?? collect([]);
    }

    public function get($key , $related = true)
    {
        if ($key instanceof Model) {
            $item = $this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first();
        } else {
            $item = $this->cart->firstWhere('id' , $key);
        }

        return $related ? $this->withRelationshipIfExists($item) : $item;
    }

    public function put(array $value , $obj = null): static
    {
        if (! is_null($obj) && $obj instanceof Model) {
            $value = array_merge($value , [
                'id' => Str::random(10),
                'qnty' => 1,
                'subject_id' => $obj->id,
                'subject_type' => get_class($obj),

            ]);
        } elseif ( ! isset($value['id'])) {
            $value = array_merge($value , [
                'id' => Str::random(10),
            ]);
        }

        $this->cart->put($value['id'] , $value);
        session()->put('cart' , $this->cart);

        return $this;
    }

    public function update($key , $option): static
    {
        $item = collect($this->get($key , false));

        if (is_numeric($option)) {
            $item = $item->merge([
               'qnty' => $item['qnty'] + $option,
            ]);
        }


        $this->put($item->toArray());
        return $this;

    }

    public function delete($key)
    {
        if ($this->has($key)) {
            $this->cart = $this->cart->filter(function ($item) use ($key) {
                if ($key instanceof Model) {
                    return ( $item['subject_id'] != $key->id ) && ( $item['subject_type'] != get_class($key) );
                }
                return $key != $item['id'];
            });
            session()->put('cart' , $this->cart);
        }
    }

    public function has($key): bool
    {
        if ($key instanceof Model) {
            return ! is_null($this->cart->where('subject_id' , $key->id)->where('subject_type' , get_class($key))->first());
        }

        return ! is_null($this->cart->firstWhere('id' , $key));
    }

    public function all()
    {
        $cart = $this->cart;
        $cart = $cart->map(function ($item) {
            return $this->withRelationshipIfExists($item);
        });
        return $cart;
    }

    public function count($key)
    {
        if ( ! $this->has($key)) return 0;
        return  $this->get($key)['qnty'];
    }

    public function clear(): void
    {
        session()->forget('cart');
    }

    protected function withRelationshipIfExists($item){
        if (isset( $item['subject_id']) && isset( $item['subject_type'] )){
            $class = $item['subject_type'];
            $subject = (new $class())->find( $item['subject_id'] );
            $item[class_basename($class)] = $subject;

            unset($item['subject_type']);
            unset($item['subject_id']);
            return $item;
        }

        return $item;
    }

}
