import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: 'http://localhost:8000',
  withCredentials: true,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

axiosInstance.interceptors.request.use(config => {
  const matches = document.cookie.match(new RegExp('(^| )XSRF-TOKEN=([^;]+)'))
  if (matches) {
    config.headers['X-XSRF-TOKEN'] = decodeURIComponent(matches[2])
  }
  return config
})

let isRefreshing = false
let failedQueue = []

const processQueue = (error, token = null) => {
  failedQueue.forEach(prom => {
    if (error) {
      prom.reject(error)
    } else {
      prom.resolve(token)
    }
  })
  failedQueue = []
}

axiosInstance.interceptors.response.use(
  response => response,
  error => {
    const originalRequest = error.config

    if (error.response?.status === 419 && !originalRequest._retry) {
      if (isRefreshing) {
        return new Promise((resolve, reject) => {
          failedQueue.push({ resolve, reject })
        })
          .then(() => {
            return axiosInstance(originalRequest)
          })
          .catch(err => {
            return Promise.reject(err)
          })
      }

      originalRequest._retry = true
      isRefreshing = true

      return new Promise((resolve, reject) => {
        axios.get('http://localhost:8000/sanctum/csrf-cookie')
          .then(() => {
            isRefreshing = false
            processQueue(null)
            resolve(axiosInstance(originalRequest))
          })
          .catch(err => {
            isRefreshing = false
            processQueue(err, null)
            reject(err)
          })
      })
    }

    return Promise.reject(error)
  }
)

export default axiosInstance
