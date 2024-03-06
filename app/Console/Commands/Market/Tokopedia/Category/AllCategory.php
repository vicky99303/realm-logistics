<?php

namespace App\Console\Commands\Market\Tokopedia\Category;

use App\Models\Tokopedia\Category as CategoryModel;
use App\Models\Tokopedia\tokopediaAuthTokenLifeInfo;
use App\Models\Tokopedia\TokopediaToken;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class AllCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getAllCategory:tokopedia {userId} {tokenId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        $tokenId = $this->argument('tokenId');
        if (isset(TokopediaToken::find($tokenId)->authtokens)) {
            $dataArray = TokopediaToken::find($tokenId)->with('authtokens')->get();
            if ($dataArray->isNotEmpty()) {
                foreach ($dataArray as $single) {
                    $fs_id = $single->app_id;
                    $access_token = $single->authtokens->access_token;
                    try {
                        $client = new Client();
                        $response = $client->request('GET', 'https://fs.tokopedia.net/inventory/v1/fs/' . $fs_id . '/product/category', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $access_token,
                            ]
                        ]);
                        $statusCode = $response->getStatusCode();
                        $content = json_decode($response->getBody(), true);
                        if ($statusCode == 200 && !isset($content['error'])) {
                            foreach ($content['data'] as $categories) {
                                foreach ($categories as $category) {
                                    if (isset($category['child']) && !empty($category['child'])) {
                                        foreach ($category['child'] as $child) {
                                            if (isset($child['child']) && !empty($child['child'])) {
                                                foreach ($child['child'] as $subchild) {
                                                    $dataExist1 = CategoryModel::where('cid', $category['id'])
                                                        ->where('child_id', $child['id'])
                                                        ->where('sub_child_id', $subchild['id'])
                                                        ->first();
                                                    if ($dataExist1 == NULL) {
                                                        $categoryObject = new CategoryModel;
                                                        $categoryObject->user_id = $userId;
                                                        $categoryObject->fs_id = $fs_id;
                                                        $categoryObject->name = $category['name'];
                                                        $categoryObject->cid = $category['id'];
                                                        $categoryObject->child_name = $child['name'];
                                                        $categoryObject->child_id = $child['id'];
                                                        $categoryObject->sub_child_name = $subchild['name'];
                                                        $categoryObject->sub_child_id = $subchild['id'];
                                                        $categoryObject->save();
                                                    } else {
                                                        CategoryModel::where('user_id', $userId)
                                                            ->where('fs_id', $fs_id)
                                                            ->where('cid', $category['id'])
                                                            ->where('child_id', $child['id'])
                                                            ->where('sub_child_id', $subchild['id'])
                                                            ->update(['name' => $category['name'],
                                                                'cid' => $category['id'],
                                                                'child_name' => $child['name'],
                                                                'child_id' => $child['id'],
                                                                'sub_child_name' => $subchild['name'],
                                                                'sub_child_id' => $subchild['id'],
                                                            ]);
                                                    }
                                                }
                                            } else {
                                                $dataExist2 = CategoryModel::where('cid', $category['id'])
                                                    ->where('child_id', $child['id'])
                                                    ->where('sub_child_id', $subchild['id'])
                                                    ->first();
                                                if ($dataExist2 == NULL) {
                                                    $categoryObject = new CategoryModel;
                                                    $categoryObject->user_id = $userId;
                                                    $categoryObject->fs_id = $fs_id;
                                                    $categoryObject->name = $category['name'];
                                                    $categoryObject->cid = $category['id'];
                                                    $categoryObject->child_name = $child['name'];
                                                    $categoryObject->child_id = $child['id'];
                                                    $categoryObject->sub_child_name = 'NA';
                                                    $categoryObject->sub_child_id = 0;
                                                    $categoryObject->save();
                                                } else {
                                                    CategoryModel::where('user_id', $userId)
                                                        ->where('fs_id', $fs_id)
                                                        ->where('cid', $category['id'])
                                                        ->where('child_id', $child['id'])
                                                        ->update(['name' => $category['name'],
                                                            'cid' => $content['id'],
                                                            'child_name' => $child['name'],
                                                            'child_id' => $child['id'],
                                                        ]);
                                                }
                                            }
                                        }// endforeach
                                    } else {
                                        $dataExist3 = CategoryModel::where('cid', $category['id'])
                                            ->where('child_id', $child['id'])
                                            ->first();
                                        if ($dataExist3 == NULL) {
                                            $categoryObject = new CategoryModel;
                                            $categoryObject->user_id = $userId;
                                            $categoryObject->fs_id = $fs_id;
                                            $categoryObject->name = $category['name'];
                                            $categoryObject->cid = $category['id'];
                                            $categoryObject->child_name = 'NA';
                                            $categoryObject->child_id = 0;
                                            $categoryObject->sub_child_name = 'NA';
                                            $categoryObject->sub_child_id = 0;
                                            $categoryObject->save();
                                        } else {
                                            CategoryModel::where('user_id', $userId)
                                                ->where('fs_id', $fs_id)
                                                ->where('cid', $category['id'])
                                                ->update(['name' => $category['name'],
                                                    'cid' => $content['id']
                                                ]);
                                        }
                                    }//endif-else
                                }//endforeach
                            }//endforeach
                            return 1;
                        }
                    }catch(Exception $exception){
                        return $exception->getCode();
                    }
                }
            }
        }
    }
}
