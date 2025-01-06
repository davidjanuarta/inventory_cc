pipeline {  
    agent any  

    environment {  
        DOCKERHUB_USERNAME = credentials('david03') // Ganti 'dockerhub-username' dengan ID kredensial yang sesuai  
        DOCKERHUB_PASSWORD = credentials('david03') // Ganti 'dockerhub-password' dengan ID kredensial yang sesuai  
        IMAGE_NAME = 'inventorytvri-php:latest' // Ganti dengan nama image Anda  
    }  

    stages {  
        stage('Checkout Source Code') {  
            steps {  
                echo "Checking out the code from GitHub"  
                checkout scm  
            }  
        }  

        stage('Build Docker Image') {  
            steps {  
                echo "Building Docker image"  
                script {  
                    // Pastikan untuk menggunakan PowerShell pada Windows  
                    powershell """  
                        docker build -t ${inventorytvri-php} .  
                    """  
                }  
            }  
        }  

        stage('Login to DockerHub') {  
            steps {  
                echo "Logging in to DockerHub"  
                script {  
                    // Login ke DockerHub  
                    powershell """  
                        echo ${DOCKERHUB_PASSWORD} | docker login -u ${DOCKERHUB_USERNAME} --password-stdin  
                    """  
                }  
            }  
        }  

        stage('Push Docker Image to DockerHub') {  
            steps {  
                echo "Pushing Docker image to DockerHub"  
                script {  
                    // Dorong image yang telah dibangun ke DockerHub  
                    powershell """  
                        docker push ${IMAGE_NAME}  
                    """  
                }  
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
