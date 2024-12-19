package com.example.student;

import org.junit.jupiter.api.Test;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.test.context.ActiveProfiles;
@SpringBootTest
@ActiveProfiles("test")  // This loads application-test.properties
public class StudentApplicationTests {

    @Test
    void contextLoads() {
        // Test logic here
    }
}

