#!groovy​

def withMyCredentials(body) {
  withCredentials([
    [$class: 'StringBinding', credentialsId: 'S3ACCESSID', variable: 'S3ACCESSID'],
    [$class: 'StringBinding', credentialsId: 'S3LINK', variable: 'S3LINK'],
    [$class: 'StringBinding', credentialsId: 'S3SECRET', variable: 'S3SECRET'],
    [$class: 'StringBinding', credentialsId: 'S3Bucket', variable: 'BUCKET']
  ],
 body)
}

node {
    def app

    stage('Clone repository') {
        /* Let's make sure we have the repository cloned to our workspace */
        checkout scm
    }

    stage('Update Project Libraries') {
        dir ('imgmanage') {
            sh 'composer install'
        }
    }

    stage('Run Test Steps') {
        dir ('imgmanage') {
            withMyCredentials {
                sh 'ant full-build'
            }
        }
    }

    stage('Publish Reports') {
        step([
            $class: 'CloverPublisher',
            cloverReportDir: 'imgmanage/build/logs/',
            cloverReportFileName: 'clover.xml',
            healthyTarget: [methodCoverage: 70, conditionalCoverage: 80, statementCoverage: 80], // optional, default is: method=70, conditional=80, statement=80
            unhealthyTarget: [methodCoverage: 50, conditionalCoverage: 50, statementCoverage: 50], // optional, default is none
            failingTarget: [methodCoverage: 0, conditionalCoverage: 0, statementCoverage: 0]     // optional, default is none
        ])
        step([
            $class: 'hudson.plugins.checkstyle.CheckStylePublisher',
            checkstyle: 'imgmanage/build/logs/checkstyle.xml'
            ])
    }


    stage('Build Container') {
        /* This builds the actual image; synonymous to
        * docker build on the command line */
        dir ('imgmanage') {
            app = docker.build("bradb59/wc-imgmanage")
        }
    }

    stage ('Run container') {
        dir ('imgmanage') {
            sh 'docker-compose  -f docker-compose.yml up -d'
        }
    }


    stage ('Run Integration Testing') {
        dir ('imgmanage') {
            withMyCredentials {
                sh 'ant behat'
            }
        }
    }


    stage('Publish Container') {
        /* Finally, we'll push the image with two tags:
        * First, the incremental build number from Jenkins
        * Second, the 'latest' tag.
        * Pushing multiple tags is cheap, as all the layers are reused. */

        docker.withRegistry('https://registry.hub.docker.com', 'DockerHubLogin') {
            app.push("latest")
            app.push("${env.BUILD_NUMBER}")
         }
    }

    stage ('Cleanup Container') {
        dir ('imgmanage') {
            sh 'docker-compose  -f docker-compose.yml down'
        }
    }

}