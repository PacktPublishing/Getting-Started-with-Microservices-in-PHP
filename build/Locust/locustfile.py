from locust import HttpLocust, TaskSet, task

class WineImgManageTaskList(TaskSet):
    @task(2)
    def get_url(self):
        self.client.get("/image/url/default_user.jpg")

    @task(1)
    def getImageFile(self):
        self.client.get("/image/default_user.jpg")

class MyLocust(HttpLocust):
    task_set = WineImgManageTaskList
    min_wait = 5000
    max_wait = 15000
