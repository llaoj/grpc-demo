package model

import (
	"fmt"
	"log"
	// "time"

	"github.com/jinzhu/gorm"
	_ "github.com/jinzhu/gorm/dialects/mysql"

	"grpc-server/config"
)

var db *gorm.DB

func Setup() {
	var err error
	cfg := config.Get()
	db, err = gorm.Open(cfg.Db.Default.Type, fmt.Sprintf("%s:%s@tcp(%s)/%s?charset=utf8mb4&parseTime=True&loc=Local",
		cfg.Db.Default.User,
		cfg.Db.Default.Password,
		cfg.Db.Default.Host,
		cfg.Db.Default.Database))
	if err != nil {
		log.Fatalf("error: %v", err)
	}

	db.SingularTable(true)
	db.LogMode(true)
	db.DB().SetMaxIdleConns(10)
	db.DB().SetMaxOpenConns(100)
}

func CloseDB() {
	defer db.Close()
}
