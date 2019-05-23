define({ "api": [
  {
    "type": "get",
    "url": "/image/{file}",
    "title": "Get an Image Base File, no resizing done",
    "name": "getImageFile",
    "group": "Image",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "file",
            "description": "<p>The File Key requested.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "image",
            "description": "<p>The Actual Image</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./routes/web.php",
    "groupTitle": "Image"
  },
  {
    "type": "get",
    "url": "/image/{file}/size/{height}x{width}",
    "title": "Get an Image resized",
    "name": "getImageFileResized",
    "group": "Image",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "file",
            "description": "<p>The File Key requested.</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "height",
            "description": "<p>The Height for the image</p> "
          },
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "width",
            "description": "<p>The Width of the image</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "image",
            "description": "<p>The Actual Image</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./routes/web.php",
    "groupTitle": "Image"
  },
  {
    "type": "get",
    "url": "/image/url/{file}",
    "title": "Get an Image Url for a specified file",
    "name": "getImageUrl",
    "group": "Image",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "file",
            "description": "<p>The File Key requested.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "url",
            "description": "<p>The publicly Accessible URL</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n {\"url\":\"https:www.example.com/image.jpg\"}\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Error",
            "description": "<p>Inability to store the image, retry.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Error-Response:",
          "content": "HTTP/1.1 404 Not Found\n{\n  \"error\":\"No Such File\"\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "./routes/web.php",
    "groupTitle": "Image"
  },
  {
    "type": "post",
    "url": "/image",
    "title": "Publish New Image to service",
    "name": "newImage",
    "group": "Image",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "<p>File</p> ",
            "optional": false,
            "field": "photo",
            "description": "<p>Image To Be Stored.</p> "
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "set",
            "description": "<p>Date/Time that the image was stored.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "file",
            "description": "<p>Name of the file to reference.</p> "
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n{\n \"set\": \"2017-05-18T23:54:43+00:00\",\n \"file\": \"abee860e6b8ac692751cc20ab95befc5.JPG\"\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Error",
            "description": "<p>Inability to store the image, retry.</p> "
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "./routes/web.php",
    "groupTitle": "Image"
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p> "
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./docs/main.js",
    "group": "_home_bradb_projects_winecollection_imgmanage_docs_main_js",
    "groupTitle": "_home_bradb_projects_winecollection_imgmanage_docs_main_js",
    "name": ""
  },
  {
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "optional": false,
            "field": "varname1",
            "description": "<p>No type.</p> "
          },
          {
            "group": "Success 200",
            "type": "<p>String</p> ",
            "optional": false,
            "field": "varname2",
            "description": "<p>With type.</p> "
          }
        ]
      }
    },
    "type": "",
    "url": "",
    "version": "0.0.0",
    "filename": "./public/docs/main.js",
    "group": "_home_bradb_projects_winecollection_imgmanage_public_docs_main_js",
    "groupTitle": "_home_bradb_projects_winecollection_imgmanage_public_docs_main_js",
    "name": ""
  }
] });