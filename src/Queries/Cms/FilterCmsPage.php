<?php

namespace Webkul\GraphQLAPI\Queries\Cms;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterCmsPage extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array $input
     * @return \Illuminate\Http\Response
     */
    public function __invoke($query, $input)
    {
        $arguments = $this->getFilterParams($input);

        //filter Both the relationship Address for page_title and url_key
       if (isset($arguments['page_title']) && isset($arguments['url_key']) ) {

            $pageTitle = $input['page_title'];

            $urlKey = $input['url_key'];

            unset($arguments['page_title']);

            unset($arguments['url_key']);

            return $query->whereHas('translations',function ($q) use ($pageTitle,$urlKey) {
        
                $q->where([
                    "page_title" => $pageTitle,
                    "url_key"    => $urlKey
                ]);
                
            })->where($arguments);
        }  

        // get the page_title value and store in $pageTitle variable
        if (isset($arguments['page_title'])) {

            $pageTitle = $arguments['page_title'];

            unset($arguments['page_title']);

            return $query->whereHas('translations',function ($q) use ($pageTitle) {
               
                $q->where("page_title", $pageTitle);
                
            })->where($arguments);
        }     

        // get the url_key value and store in $urlKey variable
        if (isset($arguments['url_key'])) {

            $urlKey = $arguments['url_key'];

            unset($arguments['url_key']);

            return $query->whereHas('translations',function ($q) use ($urlKey) {
    
                $q->where("url_key", $urlKey);
                
            })->where($arguments);
        } 

        return $query->where($arguments);
    } 
}  
