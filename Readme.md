# Product Replaced By

Ce module permet de définir le produit qui vient en remplacement.
Vous pourrez alors indiquer, lorsque l'ancien produit est affiché, le produit de remplacement.

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is ProductReplacedBy.
* Activate it in your thelia administration panel

## Back-office

Le module ajoute un entrée 'Product Replaced By' dans sur la fiche du produit dans le back-office.


## Loop

[product-replaced-by]

### Input arguments

|Argument |Description |
|---      |--- |
|**product_id** | id du l'ancien produit. |
|**replaced_by_id** | id du nouveau produit. |

### Output arguments

|Variable   |Description |
|---        |--- |
|$PRODUCT_ID | id du l'ancien produit. |
|$REPLACED_BY_ID | id du nouveau produit. |

### Exemple

{loop type="product-replaced-by" product_id=$ID}

    {loop type="product" id=$REPLACED_BY_ID}....{/loop}
    
{/loop}

*****
Vous pouvez également vérifier si un produit est remplacé en utilisant l'extension Smarty :
le paramètre __find__ peut prendre les valeurs suivantes:

|Valeur   |Description |
|---        |--- |
| **first** (valeur par défaut) | renvoie l'ID du produit de remplacement |
| last | Si le produit est remplacé par un produit, ce dernier est rempacé aussi... renvoie l'ID du dernier produit de remplacement |
| all | renvoie la liste de tous les produits de remplacement |

```html
{product_replaced_by product_id=$ID find="last"}
```
