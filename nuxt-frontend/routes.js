export const hooks = {
    'pages:extend' (pages) {
        pages.push({
            name: 'home',
            path: '/',
            file: '~/pages/index.vue'
        }),

        pages.push({
            name: 'login',
            path: '/login',
            file: '~/pages/auth/login.vue'
        }),

        pages.push({
            name: 'register',
            path: '/register',
            file: '~/pages/auth/register.vue'
        }),
        pages.push({
            name: 'verification.notice',
            path: '/verification-notice',
            file: '~/pages/auth/verification-notice.vue'
        }),
        pages.push({
            name: 'verification.verify',
            path: '/email/verify',
            file: '~/pages/auth/verification-verify.vue'
        }),

        pages.push({
            name: 'instructor.dashboard',
            path: '/instructor',
            file: '~/pages/instructor/courses/dashboard.vue'
        }),
        pages.push({
            name: 'instructor.courses.basic',
            path: '/instructor/c/:course/basic',
            file: '~/pages/instructor/courses/basic.vue'
        }),
        pages.push({
            name: 'instructor.courses.curriculum',
            path: '/instructor/c/:course/curriculum',
            file: '~/pages/instructor/courses/curriculum.vue'
        }),
        pages.push({
            name: 'instructor.courses.targets',
            path: '/instructor/c/:course/targets',
            file: '~/pages/instructor/courses/targets.vue'
        }),
        pages.push({
            name: 'instructor.courses.pricing',
            path: '/instructor/c/:course/pricing',
            file: '~/pages/instructor/courses/pricing.vue'
        }),
        pages.push({
            name: 'courses.purchase',
            path: '/c/:course/purchase',
            file: '~/pages/course/purchase.vue'
        }),
        pages.push({
            name: 'courses.show',
            path: '/c/:course',
            file: '~/pages/course/show.vue'
        }),
        pages.push({
            name: 'courses.learn',
            path: '/c/:course/learn/:lecture',
            file: '~/pages/course/learn.vue'
        }),
        pages.push({
            name: 'courses.questions',
            path: '/c/:course/learn/:lecture/qa',
            file: '~/pages/course/questions.vue'
        }),
        pages.push({
            name: 'courses.reviews',
            path: '/c/:course/learn/:lecture/reviews',
            file: '~/pages/course/reviews.vue'
        })
    }
}

