POST https://api.cloudflare.com/client/v4/zones/1130366eacb38c45e6237f07ebf87994/pagerules HTTP/1.1
X-Auth-Email: yokowasis@gmail.com
X-Auth-Key: 52115cca3a7b3a4ad11462e9b67b9876e88f6
Content-Type: application/json

{
    "targets":
    [
      {
        "target": "url",
        "constraint": {
          "operator": "matches",
          "value": "https://bimbelmatriks.com/*upload*"
        }        
      }
    ],
    "actions":
    [
        {
          "id": "cache_level",
          "value": "cache_everything"
        },
        {
          "id": "edge_cache_ttl",
          "value": 7200
        },
        {
          "id": "explicit_cache_control",
          "value": "on"
        }
    ],
    "priority" : 1,
    "status": "active"                    
}



###

GET https://api.cloudflare.com/client/v4/zones/1130366eacb38c45e6237f07ebf87994/pagerules HTTP/1.1
X-Auth-Email: yokowasis@gmail.com
X-Auth-Key: 52115cca3a7b3a4ad11462e9b67b9876e88f6
Content-Type: application/json

###

DELETE https://api.cloudflare.com/client/v4/zones/1130366eacb38c45e6237f07ebf87994/pagerules/5975ea62238ffd98c5f6e267d5f1bb0f HTTP/1.1
X-Auth-Email: yokowasis@gmail.com
X-Auth-Key: 52115cca3a7b3a4ad11462e9b67b9876e88f6
Content-Type: application/json
