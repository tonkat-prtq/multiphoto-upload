<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;


class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('item.index', compact('items'));
    }

    public function create(Request $request)
    {

        // POST
        if ($request->isMethod('POST')) {

            // 商品情報の保存
            $item = Item::create([
                // フォームから送られてきた情報が$requestに入っている
                // Itemテーブルのjanカラムには、ユーザーの入力にアクセスしjanというフィールドの値を入れている(動的プロパティでの入力取得)
                'jan' => $request->jan,
                'name' => $request->name
                ]);
            

            /*
                商品画像の保存
                $index には それが何枚目の画像かという情報が入ってる？
                $eには画像の情報
                $extにはファイルの形式
                $filenameにはファイルの名前
            */

            // アップロードされたファイルの数だけ繰り返す
            foreach ($request->file('files') as $index=> $e) {
                // guessExtensionでアップロードしたファイルの拡張子を取得
                $ext = $e['photo']->guessExtension();
                // 変数$filenameに、"jan番号"_"何枚目の画像か"."ファイルの形式"とリネーム用の文字列を準備する
                $filename = "{$request->jan}_{$index}.{$ext}";
                // storeAsで保存するファイル名を指定して、'photos'ディスクに保存、そのパスを変数$pathに入れている\
                $path = $e['photo']->storeAs('photos', $filename);
                // photosメソッドにより、商品に紐付けられた画像を保存する
                $item->photos()->create(['path'=> $path]);

                // dd($index, $e, $ext, $filename, $path);
            }

            // 「保存しました」というフラッシュメッセージを表示し、/itemsにitems#indexを通って遷移する
            return redirect('/items')->with(['success' => '保存しました']);
        }


        // GET
        return view('item.create');
    }
}
