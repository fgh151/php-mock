<?php

return array(
    'GET'=>array(
      'product_categories'=>array(
          'response'=>'{
    "promo_campaigns": [
        {
            "id": 1,
            "caption": "Электроника",
            "description": "Описание категории",
            "links": {
                "children": { "ids": [2, 3, 4] },
                "products": { "ids": [1, 2, 3] }
            }
        },
        {
            "id": 2,
            "caption": "Смартфоны",
            "description": "Описание категории",
            "links": {
                "parent": { "href": "/product_categories/1", "id": 1 }
                "children": { "ids": [] },
                "products": { "ids": [] }
            }
        }
    ]
}',
          'headers'=>array(
            'response_code'=>200
          )
      ),
    )
);
?>
