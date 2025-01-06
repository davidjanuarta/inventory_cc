pipeline {  
    agent any  

    stages {  
        stage('Git Checkout') {  
            steps {  
                echo "Checking out the code from SCM"  
                checkout scm  
            }  
        }  

        stage('Sending Dockerfile to Ansible Server') {  
            steps {  
                echo "Sending Dockerfile to the Ansible server"  
                // Tambahkan perintah untuk menyalin Dockerfile ke server Ansible, misalnya menggunakan SCP  
                powershell 'scp -i path/to/your/key Dockerfile user@ansible-server:/path/to/destination'  
            }  
        }  

        stage('Docker Build Image') {  
            steps {  
                echo "Building Docker image"  
                // Misalnya, jika Anda sudah berada di direktori yang benar:  
                powershell 'docker build -t your-image-name:latest .'  
            }  
        }  

        stage('Push Docker Images to DockerHub') {  
            steps {  
                echo "Logging in to DockerHub"  
                powershell 'echo $DOCKERHUB_PASSWORD | docker login -u $DOCKERHUB_USERNAME --password-stdin'  

                echo "Pushing Docker image to DockerHub"  
                powershell 'docker push your-image-name:latest'  
            }  
        }  

        stage('Copy Files from Jenkins to Kubernetes Server') {  
            steps {  
                echo "Copying files from Jenkins to the Kubernetes server"  
                // Gunakan SCP untuk menyalin file ke server Kubernetes  
                powershell 'scp -i path/to/your/key some-file user@k8s-server:/path/to/destination'  
            }  
        }  

        stage('Kubernetes Deployment using Ansible') {  
            steps {  
                echo "Deploying application to Kubernetes using Ansible"  
                // Jalankan playbook Ansible untuk melakukan deployment  
                powershell 'ansible-playbook -i inventory your-playbook.yml'  
            }  
        }  
    }  

    post {  
        success {  
            echo "Pipeline executed successfully!"  
        }  
        failure {  
            echo "Pipeline failed!"  
        }  
    }  
}
