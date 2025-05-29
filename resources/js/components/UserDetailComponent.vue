<template>
   <div class="container">
      <h4 class="mb-4 text-center" style="font-weight: 700; font-size: 35px">
         Tài khoản
      </h4>
      <div class="row">
         <div class="col-7" style="border: 1px #8bc34a dotted">
            <div class="p-3">
               <div class="profile-header">
                  <img
                     src="https://www.bhdstar.vn/wp-content/assets/loodo/no-user.jpg"
                     alt="Avatar"
                     class="avatar"
                     />
                  <div class="d-flex flex-column gap-2">
                     <h2>{{ user.name }} {{ user.surname }}</h2>
                     <p>Điểm RP: <b>0</b> | Tổng visit: <b>0</b></p>
                     <p>
                        Expired visit: <b>0</b> | Active visit: <b>0</b>
                     </p>
                     <p>Tổng chi tiêu: <b>0 VND</b></p>
                     <small>
                     <i
                        >Vui lòng đăng ảnh chân dung, thấy rõ mặt có
                     kích thước ngang 200 pixel và dung lượng
                     dưới 1MB</i
                        >
                     </small>
                  </div>
               </div>
               <div class="divider"></div>
               <form @submit.prevent="updateUser">
                  <div class="row">
                     <div class="col-md-6">
                        <label class="form-label">Họ *</label>
                        <input
                           type="text"
                           v-model="user.surname"
                           class="form-control"
                           />
                     </div>
                     <div class="col-md-6">
                        <label class="form-label"
                           >Tên đệm và tên *</label
                           >
                        <input
                           type="text"
                           v-model="user.name"
                           class="form-control"
                           />
                     </div>
                  </div>
                  <div class="mt-3">
                     <label class="form-label">Email *</label>
                     <input
                        type="email"
                        class="form-control"
                        :value="user.email"
                        disabled
                        />
                  </div>
                  <div class="mt-3">
                     <label class="form-label">Mật khẩu</label>
                     <div class="input-group">
                        <input
                           type="password"
                           class="form-control"
                           value="********"
                           disabled
                           />
                        <button
                           class="btn btn-green mt-3"
                           type="button"
                           >
                        <a
                           class="text-decoration-none text-white"
                           href="/forgot-password"
                           >ĐỔI MẬT KHẨU</a
                           >
                        </button>
                     </div>
                  </div>
                  <div class="mt-3">
                     <label class="form-label">Số điện thoại *</label>
                     <input
                        type="text"
                        v-model="user.phone"
                        class="form-control"
                        />
                  </div>
                  <div class="mt-3">
                     <label class="form-label">Giới tính *</label>
                     <select class="form-control" v-model="user.gender">
                        <option value="1">Nam</option>
                        <option value="2">Nữ</option>
                        <option value="0">Khác</option>
                     </select>
                  </div>
                  <div class="mt-3 row">
                     <div class="col-md-4">
                        <label class="form-label">Ngày sinh *</label>
                        <select class="form-control" v-model="day">
                           <option v-for="i in 31" :key="i" :value="i">
                              {{ i }}
                           </option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Tháng</label>
                        <select class="form-control" v-model="month">
                           <option v-for="i in 12" :key="i" :value="i">
                              {{ i }}
                           </option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label">Năm</label>
                        <select class="form-control" v-model="year">
                           <option
                              v-for="i in years"
                              :key="i"
                              :value="i"
                              >
                              {{ i }}
                           </option>
                        </select>
                     </div>
                  </div>
                  <div class="mt-3">
                     <label class="form-label">Tỉnh/Thành phố</label>
                     <input
                        type="text"
                        v-model="user.province"
                        class="form-control"
                        />
                  </div>
                  <button class="btn btn-green mt-4 mb-4" type="submit">
                  CẬP NHẬT
                  </button>
               </form>
               <div class="divider"></div>
            </div>
         </div>
         <!-- QR Code Box -->
         <div class="col-5">
            <div class="row">
               <div class="p-3">
                  <div class="qr-box row">
                     <div class="col-4">
                        <img
                           src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNbuCgdtNT6LH1bCGXtIZGt76s4Qpd8ybiFQ&s"
                           alt="QR Code"
                           width="100%"
                           />
                     </div>
                     <div class="col-7 d-flex flex-column">
                        <p>
                           Tên đăng nhập: <b>{{ user.email }}</b>
                        </p>
                        <p>Số thẻ: <b>ONLA1171582</b></p>
                        <p>Hạng thẻ: <b>Star</b></p>
                        <p>
                           Ngày đăng ký: <b>{{ formattedDate }}</b>
                        </p>
                     </div>
                  </div>
                  <button class="btn btn-green mt-4" @click="logout">
                  <span style="color: whitesmoke">ĐĂNG XUẤT</span>
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>
<script>
   export default {
       name: "UserDetailComponent",
       data() {
           return {
               user: {
                   name: "",
                   surname: "",
                   email: "",
                   phone: "",
                   gender: "0",
                   date_of_birth: "",
                   province: "",
                   created_at: "",
               },
               day: 1,
               month: 1,
               year: 2000,
               years: [],
           };
       },
       computed: {
           formattedDate() {
               if (!this.user.created_at) return "";
               const date = new Date(this.user.created_at);
               const day = String(date.getDate()).padStart(2, "0");
               const month = String(date.getMonth() + 1).padStart(2, "0");
               const year = date.getFullYear();
               return `${day}/${month}/${year}`;
           },
       },
       mounted() {
           const user = JSON.parse(localStorage.getItem("user")).data;
           console.log(user);
           if (user) {
               this.user = { ...this.user, ...user };
               // Parse ngày sinh
               if (this.user.date_of_birth) {
                   const [y, m, d] = this.user.date_of_birth.split("-");
                   this.year = Number(y);
                   this.month = Number(m);
                   this.day = Number(d);
               }
           }
           // Tạo danh sách năm
           for (let i = 1900; i <= 2025; i++) {
               this.years.push(i);
           }
       },
       methods: {
           updateUser() {
              fetch("/api/user/update", {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/json",
                      Authorization: `Bearer ${localStorage.getItem("token")}`,
                  },
                  body: JSON.stringify({
                      surname: this.user.surname,
                      name: this.user.name,
                      phone: this.user.phone,
                      gender: this.user.gender,
                      province: this.user.province,
                      day: this.day,
                      month: this.month,
                      year: this.year,
                  }),
              })
              .then((response) => response.json())
              .then((data) => {
                  if (data.status === 200 && data.data && data.data.user) {
                      alert("Cập nhật thông tin thành công!");
                      localStorage.setItem("user", JSON.stringify({ data: data.data.user }));
                      // Cập nhật lại user trên component
                      this.user = { ...this.user, ...data.data.user };
                  } else {
                      alert("Cập nhật thông tin thất bại!");
                  }
              })
              .catch((error) => {
                  console.error("Error:", error);
              });
          },
           logout() {
               localStorage.removeItem("token");
               localStorage.removeItem("user");
               window.location.href = "/login";
           },
       },
   };
</script>
<style scoped>
   .profile-container {
   max-width: 900px;
   background: #fff;
   padding: 20px;
   margin: 50px auto;
   border-radius: 8px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
   }
   .avatar {
   width: 120px;
   height: 120px;
   border-radius: 50%;
   border: 2px solid #8bc34a;
   }
   .profile-header {
   display: flex;
   align-items: center;
   gap: 15px;
   }
   .profile-header h2 {
   color: #4caf50;
   font-size: 20px;
   margin-bottom: 5px;
   }
   .profile-header p {
   font-size: 14px;
   margin: 0;
   }
   .divider {
   border-top: 1px dashed #ccc;
   margin: 15px 0;
   }
   .btn-green {
   background-color: #4caf50;
   color: white;
   border-radius: 5px;
   padding: 8px 15px;
   border: none;
   width: 100%;
   font-size: 16px;
   }
   .btn-green:hover {
   background-color: #388e3c;
   }
</style>
