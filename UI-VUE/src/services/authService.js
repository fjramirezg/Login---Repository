import axios from "axios";

const apiClient = axios.create({
  baseURL: "http://localhost:8000/api",
  headers: {
    "Content-Type": "application/json",
  },
});

export default {
  login(email, password) {
    return apiClient.post("/login", { email, password });
  },
  logout() {
    return apiClient.post("/logout");
  },
};
