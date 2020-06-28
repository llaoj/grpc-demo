package model

import (
	"time"
)

type Job struct {
	Id               int
	Name             string
	CompanyId        int
	Status           int
	UpdatedAt        *time.Time
}

func (Job) TableName() string {
	return "job"
}

func (j *Job) Get(where map[string]interface{}) {
	// db.Where(where).First(j)
	j.Id = where["id"].(int)
	j.Name = "测试工作"
	j.CompanyId = 1
	j.Status = 2
}
