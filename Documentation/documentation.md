# Documentation Bilemo

## ***GET \<host>/api/login***
### Description
Récupère un token pour l'accès aux ressources
### Paramètres
|Nom|Situé dans|Valeur|Requis|
| - | - | -| -| - | - |
||BODY|{"username":"\<username>","password":"\<password>"}| oui
|Content-Type|HEADER|application/json| oui |
### Réponse
#### Succès
|Code|Description|Schéma|
| - | - | - |
|200|OK|{"token": "\<token>"}|
#### Erreurs
|Code|Description|Schéma|
| - | - | - |
|401|Unauthorized|{"code": 401,"message": "Invalid credentials."}|

## ***GET \<host>/api/products***
### Description
Récupère la liste des produits Bilemo
### Paramètres
|Nom|Situé dans|Valeur|Requis|
| - | - | -| -| - | - |
| Authorization | HEADER | \<token> | oui |
| page | QUERY | integer | non |
### Réponse
#### Succès
|Code|Description|Schéma|
| - | - | - |
|200|OK|Collection de produits paginés en JSON|

Exemple de JSON : 
```JSON
{
	"@context": "\/api\/contexts\/Product",
	"@id": "\/api\/products",
	"@type": "hydra:Collection",
	"hydra:member": [
		{
			"@id": "\/api\/products\/1601",
			"@type": "Product",
			"id": 1601,
			"name": "Galaxy note 0",
			"brand": "Samsung",
			"weight": 341
		},
        (...)
        	],
	"hydra:totalItems": 100,
	"hydra:view": {
		"@id": "\/api\/products?page=1",
		"@type": "hydra:PartialCollectionView",
		"hydra:first": "\/api\/products?page=1",
		"hydra:last": "\/api\/products?page=10",
		"hydra:next": "\/api\/products?page=2"
	}
}
``` 
#### Erreurs
|Code|Description|Schéma|
| - | - | - |
| 401 | Expired JWT Token |  |
| 401 | JWT Token not found | |

## ***GET \<host>/api/products/{id}***
### Description
Récupère les informations détaillées d'un produit Bilemo 
### Paramètres
|Nom|Situé dans|Valeur|Requis|
| - | - | -| -| - | - |
| id | QUERY | integer | oui |
| Authorization | HEADER | \<token> | oui |
### Réponse
#### Succès
|Code|Description|Schéma|
| - | - | - |
|200|OK|Détail du produit en JSON|

Exemple de JSON: 
```JSON
{
	"@context": "\/api\/contexts\/Product",
	"@id": "\/api\/products\/1601",
	"@type": "Product",
	"id": 1601,
	"name": "Galaxy note 0",
	"brand": "Samsung",
	"weight": 341
}
```
#### Erreurs
|Code|Description|Schéma|
| - | - | - |
| 401 | Expired JWT Token | Code d'erreur en JSON |
| 401 | JWT Token not found | Code d'erreur en JSON |
| 404 | Not Found | Code d'erreur en JSON |

## ***GET \<host>/api/customers***
### Description
Récupère la liste des clients de l'entreprise de l'utilisateur
### Paramètres
|Nom|Situé dans|Valeur|Requis|
| - | - | -| -| - | - |
| Authorization | HEADER | \<token> | oui |
| page | QUERY | integer | non |
### Réponse
#### Succès
|Code|Description|Schéma|
| - | - | - |
|200|OK|Collection de client paginés en JSON|

Exemple de JSON : 
```JSON
{
	"@context": "\/api\/contexts\/Customer",
	"@id": "\/api\/customers",
	"@type": "hydra:Collection",
	"hydra:member": [
		{
			"@id": "\/api\/customers\/547",
			"@type": "Customer",
			"id": 547,
			"firstname": "Margaret",
			"lastname": "Breton"
		},
        (...)
        	],
	"hydra:totalItems": 102,
	"hydra:view": {
		"@id": "\/api\/customers?page=5",
		"@type": "hydra:PartialCollectionView",
		"hydra:first": "\/api\/customers?page=1",
		"hydra:last": "\/api\/customers?page=10",
		"hydra:previous": "\/api\/customers?page=4",
		"hydra:next": "\/api\/customers?page=6"
	}
}
```
#### Erreurs
|Code|Description|Schéma|
| - | - | - |
| 401 | Expired JWT Token |  |
| 401 | JWT Token not found | |

## ***GET \<host>/api/customers/{id}***
### Description
Récupère le détail d'un client de l'entreprise de l'utisateur
### Paramètres
|Nom|Situé dans|Valeur|Requis|
| - | - | -| -| - | - |
| id | QUERY | integer | oui |
| Authorization | HEADER | \<token> | oui |
### Réponse
#### Succès
|Code|Description|Schéma|
| - | - | - |
|200|OK|Détail du produit en JSON|

Exemple de JSON: 
```JSON
{
	"@context": "\/api\/contexts\/Customer",
	"@id": "\/api\/customers\/547",
	"@type": "Customer",
	"id": 547,
	"firstname": "Margaret",
	"lastname": "Breton"
}
```
#### Erreurs
|Code|Description|Schéma|
| - | - | - |
| 401 | Expired JWT Token | Code d'erreur en JSON |
| 401 | JWT Token not found | Code d'erreur en JSON |
| 404 | Not Found | Code d'erreur en JSON |
## ***POST \<host>/api/customers***
### Description
Ajoute un client pour l'entreprise de l'utilisateur
### Paramètres
|Nom|Situé dans|Valeur|Requis|
| - | - | -| -| - | - |
| Authorization | HEADER | \<token> | oui |
| | BODY | {"firstname":"\<firstname>","lastname":"\<lastname>"}
### Réponse

#### Succès
|Code|Description|Schéma|
| - | - | - |
|201| Created | client créé en JSON|

Exemple de réponse JSON : 
```JSON
{
	"@context": "\/api\/contexts\/Customer",
	"@id": "\/api\/customers\/813",
	"@type": "Customer",
	"id": 813,
	"firstname": "roget",
	"lastname": "Hamon"
}
```
#### Erreurs
|Code|Description|Schéma|
| - | - | - |
| 401 | Expired JWT Token | Code d'erreur en JSON |
| 401 | JWT Token not found | Code d'erreur en JSON |
| 404 | Not Found | Code d'erreur en JSON |
## ***DELETE \<host>/api/customers/{id}***
### Description
Supprime un client de l'entreprise de l'utilisateur
### Paramètres
|Nom|Situé dans|Valeur|Requis|
| - | - | -| -| - | - |
| id | QUERY | integer | oui |
| Authorization | HEADER | \<token> | oui |
### Réponse
#### Succès
|Code|Description|Schéma|
| - | - | - |
|204| Not content | |
#### Erreurs
|Code|Description|Schéma|
| - | - | - |
| 401 | Expired JWT Token | Code d'erreur en JSON |
| 401 | JWT Token not found | Code d'erreur en JSON |
| 404 | Not Found | Code d'erreur en JSON |
| 401 | Unauthorized |