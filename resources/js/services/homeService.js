import axiosInstance from '../axious/axious';

const HomeService = {
    // Lấy tất cả phim đang chiếu và sắp chiếu (14 ngày)
    getFilms() {
        return axiosInstance.get('/user/index');
    },
    
    // Lấy danh sách rạp và combo đồ ăn
    getShop() {
        return axiosInstance.get('/user/shop');
    },
    
    // Lấy tất cả hệ thống rạp chiếu
    getTheaterSystem() {
        return axiosInstance.get('/user/theater-system');
    },
    
    // Lấy lịch chiếu theo rạp (cho ngày hôm nay)
    getTheaterSchedule() {
        return axiosInstance.get('/user/theater-schedule');
    },
    
    // Lấy lịch chiếu theo phim
    getMovieSchedule() {
        return axiosInstance.get('/user/movie-schedule');
    },

    // Lấy phim đang chiếu (hiển thị ở NowShowingComponent)
    getNowShowingFilms() {
        return this.getFilms().then(response => {
            return {
                films: response.data.films.filter(film => {
                    const today = new Date();
                    const launchDate = new Date(film.launch_date);
                    return launchDate <= today;
                })
            };
        });
    },

    // Lấy phim sắp chiếu (hiển thị ở ComingSoonComponent)
    getComingSoonFilms() {
        return this.getFilms().then(response => {
            return {
                films: response.data.commingSoon || []
            };
        });
    },

    // Lấy combo đặc biệt (hiển thị ở SpecialComboComponent)
    getSpecialCombos() {
        return this.getShop().then(response => {
            return {
                combos: response.data.foods || []
            };
        });
    }
};

export default HomeService;