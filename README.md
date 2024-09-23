
# Lahelu Meme API  
This project provides API for clonning Lahelu Meme. Authentication, Meme posts and Comments are well provided.

## Demo  
lahelu-api.riangho.com/api/v1/posts

## Run Production  
Clone the project  

~~~bash  
  git clone https://github.com/rrrgho/lahelu-api.git
~~~

Go to the project directory and build the Docker image

~~~bash  
  cd lahelu-api && docker build -t lahelu-api .
~~~

Run Container 

~~~bash  
docker run -d -p 8005:8005 lahelu-api
~~~


## Run Locally  
Clone the project  

~~~bash  
  git clone https://github.com/rrrgho/lahelu-api.git
~~~

Go to the project directory  

~~~bash  
  cd lahelu-api
~~~

Install dependencies  

~~~bash  
composer install
~~~

Start the server  

~~~bash  
php artisan serve
~~~  

## Usage/Examples  
~~~javascript  
  import axios from 'axios'

  const fetch = await axios.get('/posts').then((res) => {
    console.log(res)
  })
~~~  

## License  
[Rian Gho](https://riangho.com)  
